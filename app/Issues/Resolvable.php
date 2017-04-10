<?php


namespace App\Issues;


trait Resolvable
{
    public function resolve()
    {
        $this->parent()->delete();
    }

    protected function parent()
    {
        return Issue::where('issue_type', static::class)->where('issue_id', $this->id)->firstOrNew([]);
    }
}