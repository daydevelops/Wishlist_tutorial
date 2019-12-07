<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{

    protected $guarded = [];

    public function purchase() {
        $this->update([
            'purchased_by'=>auth()->id(),
            'purchased_at'=>Carbon::now()
        ]);
    }

    public function unpurchase() {
        $this->update([
            'purchased_by'=>null,
            'purchased_at'=>null
        ]);
    }
}
