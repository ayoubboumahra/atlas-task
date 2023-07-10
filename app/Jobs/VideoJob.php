<?php

namespace App\Jobs;

use FFMpeg;
use App\Models\Project;
use Carbon\Carbon;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\PadFilter;
use FFMpeg\Filters\Video\TextFilter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use FFMpeg\Filters\Video\DimensionsFilter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class VideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $videoDimensions = new Dimension(640, 480);
            $backgroundColor = '#000000';
            $duration = $this->getMaxLayerDuration();

            $ffmpeg = FFMpeg\FFMpeg::create();

            $video = $ffmpeg->open($this->project->videoFilePath())
                ->addFilter(new DimensionsFilter($videoDimensions, DimensionsFilter::RESIZEMODE_INSET, true))
                ->addFilter(new PadFilter($videoDimensions, $backgroundColor));

            foreach ($this->project->layers as $layer) {
                $endTime = Carbon::parse($layer->start_time)->addSeconds($layer->duration);
                $video->addFilter(new TextFilter([
                    'text' => $layer->name,
                    'x' => 10,
                    'y' => 10,
                    'fontfile' => '/path/to/your/font.ttf',
                    'fontsize' => 24,
                    'enable' => $layer->start_time.','.$endTime,
                ]));
            }

            $video->setDuration($duration);

            $videoFilePath = 'videos/' . $this->project->id . '.mp4';

            $video->save($videoFilePath, new X264('aac', 'libx264'));

            $this->sendEmailNotification('Video rendering completed successfully.');

        } catch (\Exception $e) {
            $this->sendEmailNotification('Video rendering failed. Error: '.$e->getMessage());
        }
    }

    /**
     * Send email notification
     *
     * @param  string  $message
     * @return void
     */
    private function sendEmailNotification($message)
    {
        $email = $this->project->user->email;
        Mail::raw($message, function ($message) use ($email) {
            $message->to($email)->subject('Video Rendering Notification');
        });
    }
}
