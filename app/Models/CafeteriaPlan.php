<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CafeteriaPlan
 *
 * @property integer $id
 * @property json $pockets_budget_annual
 * @property json $pockets_budget_monthly
 */

class CafeteriaPlan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cafeteria_plans';

    protected $fillable = [
        'pockets_budget_annual',
        'pockets_budget_monthly',
    ];

    const CAFETERIA_BUDGET = 400000;
    const POCKET_BUDGET_LIMIT = 200000;

    const POCKET_1 = '1';
    const POCKET_2 = '2';
    const POCKET_3 = '3';

    const POCKETS = [
        self::POCKET_1,
        self::POCKET_2,
        self::POCKET_3
    ];

    const CURRENCY = 'HUF';

    const MONTHS = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    const SAVE_SUCCESS = 'Success DB save!';
    const XML_SUCCESS = 'Your XML file successfully generated!';
    const ERROR = 'Error!';

    

}
