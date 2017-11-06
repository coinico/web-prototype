<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\ {
    ModelCreated,
    PropertyUpdated
};
use App\Models\PropertyVote;


class Property extends Model
{
    use IngoingTrait;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'updated' => PropertyUpdated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'user_id','status_id'
    ];

    /**
     * One to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(PropertyStatus::class);
    }

    /**
     * One to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class,'property_id', 'id');
    }


    /**
     * One to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function votes()
    {
        return $this->hasMany(PropertyVote::class,'property_id', 'id');
    }

    /**
     * Voting time
     *
     * @return \DateTime
     */
    public function getVotingTime(){
        $end = new \DateTime($this->getAttribute('created_at'));
        $end->add(new \DateInterval('PT10H30S'));
        $date = new \DateTime();
        $time = $date->diff($end);
        return $time;
    }

    /**
     * User vote
     *
     * @return \Integer
     */
    public function getUserVote(){
        $propertyId = $this->getAttribute('id');
        $userId = auth()->id();
        $propertyVote = PropertyVote::where(['property_id'=>$propertyId,'user_id'=>$userId])->first();

        if($propertyVote){
            return $propertyVote->getAttribute('vote');
        }else{
            return 0;
        }

    }

    /**
     * Positives votes
     *
     * @return \Integer
     */
    public function getPositiveVotes(){
        $propertyId = $this->getAttribute('id');
        $propertyVotes = PropertyVote::where(['property_id'=>$propertyId,'vote'=>"1"])->count();
        return $propertyVotes;
    }

    /**
     * Negatives votes
     *
     * @return \Integer
     */
    public function getNegativeVotes(){
        $propertyId = $this->getAttribute('id');
        $propertyVotes = PropertyVote::where(['property_id'=>$propertyId,'vote'=>"-1"])->count();
        return $propertyVotes;
    }

}
