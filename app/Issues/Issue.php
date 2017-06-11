<?php

namespace App\Issues;

use App\Events\IssueCreated;
use App\Events\IssueDeleted;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';

    protected $fillable = ['message', 'issue_id', 'issue_type'];

    protected $events = [
        'deleting' => IssueDeleted::class,
        'created' => IssueCreated::class,
    ];

    public static function createBatchUpdateIssue($message, $issueAttributes)
    {
        return static::createUnderLyingIssue($message, $issueAttributes, BatchUpdateIssue::class);
    }

    public static function createIncompleteUpdateIssue($message, $issueAttributes)
    {
        return static::createUnderLyingIssue($message, $issueAttributes, IncompleteUpdateIssue::class);
    }

    public static function createUnavailableProductIssue($message, $issueAttributes)
    {
        return static::createUnderLyingIssue($message, $issueAttributes, UnavailableProductIssue::class);
    }

    public static function createArticleUpdateIssue($message, $issueAttributes)
    {
        return static::createUnderLyingIssue($message, $issueAttributes, ArticleUpdateIssue::class);
    }

    protected static function createUnderLyingIssue($message, $issueAttributes, $issueType)
    {
        $issue = $issueType::create($issueAttributes);

        return static::create([
            'issue_id'   => $issue->id,
            'issue_type' => $issueType,
            'message'    => $message
        ]);
    }

    public function getIssueAttribute()
    {
        return (new $this->issue_type)->find($this->issue_id);
    }
}
