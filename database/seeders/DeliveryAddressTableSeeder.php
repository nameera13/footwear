<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryAddress = [
            ['id'=>1,'user_id'=>1,'firstname'=>'nameera','lastname'=>'pathan','address'=>'bhagavatpara','city'=>'Gondal','state'=>'Gujarat','country'=>'India','pincode'=>360311,'mobile'=>7383449786,'status'=>1],
            ['id'=>2,'user_id'=>2,'firstname'=>'namu','lastname'=>'khan','address'=>'devpara','city'=>'Gondal','state'=>'Gujarat','country'=>'India','pincode'=>360311,'mobile'=>6355654767,'status'=>1]
        ];
        DeliveryAddress::insert($deliveryAddress);
    }
}
