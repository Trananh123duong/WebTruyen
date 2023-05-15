<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Chapter;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Chapter;

class ListChapterQuery extends Query
{
    protected $attributes = [
        'name' => 'listChapter',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Chapter'));
    }

    public function args(): array
    {
        return [
            'story_id' => [
                'name' => 'story_id',
                'type' => Type::int(),
                'rules' => ['exists:stories,id']
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Chapter::offset($args['page'] ?? 0)
            ->limit($args['limit'] ?? 5)
            ->get();
    }
}
