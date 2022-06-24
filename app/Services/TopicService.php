<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\File;

class TopicService extends ForumService
{
    private const TOPIC_FILES_PATH = 'topic';

    public function listSequence(?string $sequence): ?string
    {
        $accessibleSequences = [
            'desc',
            'asc',
        ];

        return in_array($sequence, $accessibleSequences)
            ? $sequence
            : $accessibleSequences[0];
    }

    public function store(array $data)
    {
        $topicId = Topic::insertGetId([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'text' => $data['text'],
            'created_at' => Carbon::now()
        ]);

        if( ! empty($data['files'])) {
            $this->storeFiles($data['files'], $topicId);
        }
    }

    public function storeFiles(array $files, int $topicId)
    {
        foreach($files ?? [] as $file)
        {
            $path = $file->store(self::TOPIC_FILES_PATH);

            File::create([
                'fileable_id' => $topicId,
                'fileable_type' => Topic::class,
                'path' => $path
            ]);
        }
    }

    public function update(Topic $topic, array $data)
    {
        if($topic->files->isNotEmpty() && ! empty($data['fileToDeleteIds'])) {
            $this->destroyFiles(File::whereIn('id', $data['fileToDeleteIds'])->get());
        }

        if( ! empty($data['files'])) {
            $this->storeFiles($data['files'], $topic->id);
        }

        $topic->name = $data['name'] ?? $topic->name;
        $topic->text = $data['text'] ?? $topic->text;
        $topic->updated = true;
        $topic->updated_at = Carbon::now();

        $topic->save();
    }
}
