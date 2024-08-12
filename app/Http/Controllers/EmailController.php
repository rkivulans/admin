<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(){

        /*
        $users = [
            {
              "domain": "example.com",
              "users": [
                {
                  "email": "user@example.com",
                  "privileges": [
                    "admin"
                  ],
                  "status": "active",
                  "mailbox": "/home/user-data/mail/mailboxes/example.com/user"
                }
              ]
            }
          ]
            */
            $dati = json_decode(<<<JSON
            [
            {
                "id": "01",
                "name": "Intel Core i7-10700K",
                "description": "10th Generation Intel Core i7 Processor, 8 Cores, 16 Threads, up to 5.1 GHz",
                "price": 379.99,
                "quantity": 25
            },
            {
                "id": "02",
                "name": "AMD Ryzen 9 5900X",
                "description": "12-core, 24-Thread Unlocked Desktop Processor, up to 4.8 GHz",
                "price": 549.99,
                "quantity": 30
            },
            {
                "id": "03",
                "name": "NVIDIA GeForce RTX 3080",
                "description": "10GB GDDR6X, PCI Express 4.0, Ray Tracing and AI capabilities",
                "price": 699.99,
                "quantity": 15
            },
            {
                "id": "04",
                "name": "ASUS ROG Strix Z490-E",
                "description": "ATX Gaming Motherboard, Intel LGA 1200, 14+2 Power Stages, PCIe 3.0, WiFi 6",
                "price": 299.99,
                "quantity": 20
            },
            {
                "id": "05",
                "name": "Corsair Vengeance LPX 16GB",
                "description": "DDR4 DRAM 3200MHz C16 Memory Kit, 2x8GB",
                "price": 89.99,
                "quantity": 50
            },
            {
                "id": "06",
                "name": "Samsung 970 EVO Plus 1TB",
                "description": "NVMe M.2 Internal SSD, Up to 3,500MB/s",
                "price": 169.99,
                "quantity": 40
            },
            {
                "id": "07",
                "name": "EVGA SuperNOVA 750 G5",
                "description": "80 Plus Gold 750W, Fully Modular Power Supply",
                "price": 139.99,
                "quantity": 35
            },
            {
                "id": "08",
                "name": "Cooler Master Hyper 212 RGB",
                "description": "CPU Air Cooler, 4 Continuous Direct Contact Heatpipes, 120mm RGB Fan",
                "price": 49.99,
                "quantity": 60
            },
            {
                "id": "09",
                "name": "Seagate Barracuda 2TB",
                "description": "3.5 Inch SATA 6Gb/s Internal Hard Drive, 7200 RPM, 256MB Cache",
                "price": 54.99,
                "quantity": 45
            },
            {
                "id": "10",
                "name": "NZXT H510 Elite",
                "description": "Compact ATX Mid-Tower PC Gaming Case, Tempered Glass, Front I/O USB Type-C Port",
                "price": 149.99,
                "quantity": 20
            }
            ]
            JSON
        );
        
            

        return view('emails.index', [
            'users' => $dati
        ]);
}

}
