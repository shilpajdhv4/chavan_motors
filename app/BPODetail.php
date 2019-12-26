<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class BPODetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $primaryKey = "id";
    public $table = "tbl_bpo_details";
    
    protected $fillable = [
        'date', 'dealer_location','enquiry_no','enquiry_date','team_lead_name','dse_name','prospect_name',
        'add_1','add_2','mobile_no','almobile_no','email_id','model_name','variant_name','financer_name',
        'enquiry_status','source','buyer_type','test_drive_given','f_visit_date','state','activity',
        'landmark','followup1','followup2','followup3','followup4','final_sr_remark','assign_bpo_user_id',
        'bop_user_status','bop_user_remark','prev_bpo_user_detail','bop_status_update_date','assign_telle_caller_id',
        
        'telle_caller_status','telle_caller_remark','tellecaller_status_update_date','follow_up_date','show_branch_admin',
        'assign_tl_id','assign_dse_id','assign_dse_status','follow_up_date','make','model','color','region_no',
        'valuation_done','valuator','expected_price','offered_price','order_status','prev_telle_caller_user_detail'
    ];
}