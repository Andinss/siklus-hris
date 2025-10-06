<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Employee extends Model
{
	use SoftDeletes;
	protected $table = 'employee';
	protected $dates = ['deleted_at'];

    public function departement()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function absenceLocations()
    {
        return $this->belongsToMany(AbsenceLocation::class, 'absence_location_employee', 'employee_id', 'absence_location_id');
    }

    public function absenceLocationEmployee()
    {
        return $this->hasOne(AbsenceLocationEmployee::class, 'employee_id', 'id');
    }

    public function shiftEmployee()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id')->whereNull('deleted_at');
    }

    public function shiftGroupEmployee()
    {
        return $this->belongsTo(ShiftGroup::class, 'shift_group_id', 'id')->whereNull('deleted_at');
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_id', 'id');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id', 'id');
    }

    public function staffStatus()
    {
        return $this->belongsTo(StaffStatus::class, 'staff_status_id', 'id');
    }

    public function sex()
    {
        return $this->belongsTo(Sex::class, 'sex', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function taxStatus()
    {
        return $this->belongsTo(TaxStatus::class, 'tax_status', 'id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }
}
