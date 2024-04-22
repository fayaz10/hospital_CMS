<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $tables = [
        'medicine_type',
        'units',
        'medicine_purchase',
        'purchased_medicines',
        'expenses',
        'stock',
        'medicines'
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // foreach ($this->tables as $table)
        //     \DB::table($table)->truncate();

        
        //     \DB::table('medicine_type')->insert([
        //         [
        //             'name' => 'pomade',
        //             'label_en' => 'Pomade',
        //             'label_dr' => 'پوماد',
        //         ],
        //         [
        //             'name' => 'syrup',
        //             'label_en' => 'Syrup',
        //             'label_dr' => 'شربت',
        //         ],
        //         [
        //             'name' => 'tablet',
        //             'label_en' => 'Tablet',
        //             'label_dr' => 'گولی',
        //         ],
        //         [
        //             'name' => 'injection',
        //             'label_en' => 'Injection',
        //             'label_dr' => 'پیچکاری',
        //         ],
        //         [
        //             'name' => 'drop',
        //             'label_en' => 'Drop',
        //             'label_dr' => 'قطره',
        //         ],
        //         [
        //             'name' => 'surrench',
        //             'label_en' => 'Surrench',
        //             'label_dr' => 'سورنج',
        //         ],
        //     ]);
    
        //     \DB::table('units')->insert([
        //         [
        //             'name' => 'packet',
        //             'label_en' => 'Packet',
        //             'label_dr' => 'تخته',
        //         ],
        //         [
        //             'name' => 'bottol',
        //             'label_en' => 'Bottol',
        //             'label_dr' => 'بوتل',
        //         ],
        //         [
        //             'name' => 'piece',
        //             'label_en' => 'Piece',
        //             'label_dr' => 'عدد',
        //         ],
        //     ]);
    
        //     factory(App\Models\Pharmacist\Medicine::class, 250)->create()->each(function ($medicine) {
                
        //         $medicine->store()->save(new App\Models\Stock\Stock([
        //             'quantity' => rand(10,100),
        //             'unit_price' => rand(10,500),
        //             'currency_id' => 1,
        //         ]));
        //     });
    
        //     factory(App\Models\Pharmacist\MedicinePuchase::class, 100)->create()->each(function ($purchasedMedicines) {
                
        //         for($i = 0; $i < rand(3, 10); ++$i) {
        //             $purchasedMedicines->medicines()->attach(rand(1,500),[
        //                 'currency_id' => 1,
        //                 'total_price' => rand(100,2000),
        //                 'quantity' => rand(10,100),
        //                 'benefits' => 48,
        //             ]);
        //         }
    
        //         $purchasedMedicines->spend()->save(new App\Models\FinanceModule\Expense([
        //             'payment_date' => date('Y-m-d'),
        //             'amount' => $purchasedMedicines->medicines->sum('pivot.total_price'),
        //             'currency_id' => 1,
        //             'remitter' => 'Asif Gulistani',
        //             'registrar_id' => 1,
        //         ]));
        //     });

        // factory(App\Models\Receptionist\Visit::class, 150)->create();
        // factory(App\Models\Pharmacist\MedicineStock::class, 250)->create();
        factory(App\Models\Pharmacist\Medicine::class, 1500)->create();
        // factory(App\Models\Pharmacist\MedicinePuchase::class, 250)->create()->each(function ($medicine) {
        //     $medicine->spend()->save(new App\Models\FinanceModule\Expense([
        //         'payment_date' => date('Y-m-d'),
        //         'amount' => $medicine->purchase_price,
        //         'currency_id' => 1,
        //         'remitter' => 'Asif Gulistani',
        //         'registrar_id' => 1,
        //     ]));
        // });
    }
}
