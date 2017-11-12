<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\ {
    ModelCreated,
    PropertyUpdated
};
use App\Models\PropertyVote;
use App\Models\CryptoCurrency;


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

        if($end > $date) {
            $time = $end->diff($date);
        }else{
            $time = $date->diff($date);
        }
        return $time;
    }

    /**
     * Investment time
     *
     * @return \DateTime
     */
    public function getInvestmentTime(){
        $end = new \DateTime($this->getAttribute('created_at'));
        $end->add(new \DateInterval('PT10H30S'));
        $date = new \DateTime();

        if($end > $date) {
            $time = $end->diff($date);
        }else{
            $time = $date->diff($date);
        }
        return $time;
    }


    /**
     * User investment
     * @param Boolean
     * @return \Integer
     */
    public function getUserInvestment($s = false){
        $propertyId = $this->getAttribute('id');
        $userId = auth()->id();
        $propertyInvest = PropertyInvest::where(['property_id'=>$propertyId,'user_id'=>$userId])->first();

        if($propertyInvest){
            $eth_value = $propertyInvest->getAttribute('value');
            $change = CryptoCurrency::where(['alias'=>'ETH'])->first()->usd_value;
            $usd_value = $eth_value * $change;

            $return = array(
                'eth' => $eth_value,
                'usd' => $usd_value
            );

            return ($s ? $return[$s] : $return['eth']);
        }else{
            return 0;
        }
    }

    /**
     * Total investment
     * @param \Boolean
     * @return \Integer
     */
    public function getTotalInvestment($s = false){
        $propertyId = $this->getAttribute('id');
        $eth_value = PropertyInvest::where(['property_id'=>$propertyId])->sum('value');
        $change = CryptoCurrency::where(['alias'=>'ETH'])->first()->usd_value;
        $usd_value = $eth_value * $change;
        $percentage = $usd_value/$this->getAttribute('value') * 100;

        $return = array(
            'percentage' => $percentage,
            'usd' => $usd_value
        );

        return ($s ? $return[$s] : $return['usd']);

    }

    /**
     * Total investors
     *
     * @return \Integer
     */
    public function getTotalInvestors(){
        $propertyId = $this->getAttribute('id');
        $total = PropertyInvest::where(['property_id'=>$propertyId])->count();

        return $total;
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

    /**
     * Total voters
     *
     * @return \Integer
     */
    public function getTotalVoters(){
        $propertyId = $this->getAttribute('id');
        $propertyVotes = PropertyVote::where(['property_id'=>$propertyId])->count();
        return $propertyVotes;
    }


    /**
     * Voting Status
     *
     * @return \Integer
     */
    public function getVotingStatus(){
        $propertyId = $this->getAttribute('id');
        $positive  = PropertyVote::where(['property_id'=>$propertyId,'vote'=>"1"])->sum('weight');
        $total  = PropertyVote::where(['property_id'=>$propertyId])->sum('weight');
        $percentage = 0;
        if($total > 0){
            $percentage = $positive/$total*100;
        }
        return $percentage;
    }



    /**
     * Voting Data
     *
     * @return \Integer
     */
    public function getVotingData(){
        $propertyId = $this->getAttribute('id');
        $total = implode(",",PropertyVote::where(['property_id'=>$propertyId])->pluck('weight')->toArray());

        return $total;
    }



}
