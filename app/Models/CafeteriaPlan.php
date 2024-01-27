<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CafeteriaPlan
 *
 * @property integer $id
 */

class CafeteriaPlan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cafeteriaPlans';

    const CAFETERIA_BUDGET = 400000;
    const POCKET_BUDGET_LIMIT = 200000;

    const A_POCKET = 'A';
    const B_POCKET = 'B';
    const C_POCKET = 'C';

    const POCKETS = [
        self::A_POCKET,
        self::B_POCKET,
        self::C_POCKET
    ];

    const MONTHS = [
        1,2,3,4,5,6,7,8,9,10,11,12
    ];
    

}
