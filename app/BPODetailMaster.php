<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class BPODetailMaster extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $primaryKey = "bpo_id";
    public $table = "tbl_bpo_detail_master";
    
    protected $fillable = [
        'calling_set_name', 'uploaded_branch_id','uploaded_date','uploaded_time','data_set_status','file_name'
    ];
}