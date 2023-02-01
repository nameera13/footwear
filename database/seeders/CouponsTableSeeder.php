<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupon = [
            ['id'=>1,'coupon_option'=>'Manual','coupon_code'=>'test10','categories'=>'1','users'=>'','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>200,'expiry_date'=>'2023-02-15','status'=>1],
            ['id'=>2,'coupon_option'=>'Manual','coupon_code'=>'test20','categories'=>'1','users'=>'','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>400,'expiry_date'=>'2023-02-15','status'=>1],
        ];

        Coupon::insert($coupon);
    }
}
