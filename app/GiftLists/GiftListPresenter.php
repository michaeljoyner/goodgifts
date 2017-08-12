<?php


namespace App\GiftLists;


use Hemp\Presenter\Presenter;

class GiftListPresenter extends Presenter
{

    public function getRequestedByAttribute()
    {
        return $this->model->request->sender;
    }

    public function getForAttribute()
    {
        return $this->model->request->recipient;
    }

    public function getBudgetAttribute()
    {
        return $this->model->request->budgetLimit();
    }

    public function getInterestsAttribute()
    {
        $interests = collect(explode(',', $this->model->request->interests))->map(function($interest) {
            return mb_strtolower($interest);
        })->all();
        return join(', ', $interests);
    }
}