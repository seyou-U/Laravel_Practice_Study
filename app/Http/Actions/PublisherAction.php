<?php

namespace App\Http\Actions;

use App\Services\PublishService;
use Illuminate\Http\Request;

class PublisherAction
{
    private $publisher;

    public function __construct(PublishService $publisher)
    {
        $this->publisher = $publisher;
    }

    public function create(Request $request)
    {
        if ($this->publisher->exists($request->name)) {
            return response('すでに登録されています', 200);
        }

        $id = $this->publisher->store($request->name, $request->address);
        return response('新規登録完了', 201)
            ->header('Location', '/api/publishers/' . $id);
    }
}
