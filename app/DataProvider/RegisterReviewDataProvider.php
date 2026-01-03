<?php

namespace App\DataProvider;

use App\Interfaces\RegisterReviewProviderInterface;
use App\Models\Review;
use App\Models\ReviewTag;
use App\Models\Tag;

class RegisterReviewDataProvider implements RegisterReviewProviderInterface
{
    public function save(
        string $title,
        string $content,
        int $userId,
        string $createdAt,
        array $names = []
    ): int {
        $reviewId = $this->createReview($title, $content, $userId, $createdAt);
        foreach ($names as $name) {
            $this->createReviewTag(
                $reviewId,
                $this->createTag($name, $createdAt),
                $createdAt
            );
        }
        return $reviewId;
    }

    protected function createReview (string $title, string $content, int $userId, string $createdAt): int {
        $result = Review::firstOrCreate([
            'user_id' => $userId,
            'title' => $title,
        ], [
            'content' => $content,
            'created_at' => $createdAt,
        ]);

        return $result->id;
    }

    protected function createReviewTag (int $reviewId, int $tagId, string $createdAt) {
        ReviewTag::firstOrCreate([
            'tag_id' => $tagId,
            'review_id' => $reviewId,
        ], [
            'created_at' => $createdAt,
        ]);
    }

    protected function createTag (string $name, string $createdAt): int {
        $result = Tag::firstOrCreate([
            'tag_name' => $name,
        ], [
            'created_at' => $createdAt,
        ]);

        return $result->id;
    }
}
