<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Video extends Model
{
    const STATUS_READY = 1;
    use SerializesModels;

    public $timestamps = false;
    protected $table = 'videos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_url',
        'first_start',
        'first_duration',
        'second_url',
        'second_start',
        'second_duration',
        'status',
    ];

    /**
     * @param int $status
     */
    public function updateStatus(int $status)
    {
        $this->status = $status;
        $this->save();
    }

}
