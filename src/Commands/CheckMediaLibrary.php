<?php

namespace Papaedu\Extension\Commands;

use Illuminate\Console\Command;
use Papaedu\Extension\Enums\MediaStatus;
use Papaedu\Extension\MediaLibrary\MediaLibrary;
use Papaedu\Extension\Models\MediaLibrary as MediaLibraryModel;

class CheckMediaLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:media_library';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check media library.';

    public function handle()
    {
        $this->handleOnlyGenerated();
        $this->handleOnlyUsed();
    }

    protected function handleOnlyGenerated()
    {
        MediaLibraryModel::query()
            ->where('status', MediaStatus::GENERATED->value)
            ->whereBetween('created_at', [
                now()->subDays(MediaLibraryModel::EXPIRED_DAYS + 1),
                now()->subDays(MediaLibraryModel::EXPIRED_DAYS),
            ])
            ->delete();
    }

    protected function handleOnlyUsed()
    {
        $query = MediaLibraryModel::query()
            ->where('status', MediaStatus::UPLOADED->value)
            ->whereBetween('created_at', [
                now()->subDays(MediaLibraryModel::EXPIRED_DAYS + 1),
                now()->subDays(MediaLibraryModel::EXPIRED_DAYS),
            ]);

        $query->chunk(100, function ($mediaLibraries) {
            /** @var \Papaedu\Extension\Models\MediaLibrary $mediaLibrary */
            foreach ($mediaLibraries as $mediaLibrary) {
                MediaLibrary::{$mediaLibrary->type}()->delete($mediaLibrary->path);
            }
        });
        $query->delete();
    }
}
