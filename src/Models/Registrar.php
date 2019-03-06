<?php
namespace WeDevelopCoffee\wPower\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Domain model
 */
class Registrar extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tblregistrars';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['decodedValue'];


    public function listRegistrars()
    {
        return self::groupBy('registrar');
    }

    /**
     * Fetch all registrar data for the specific registrar and decode.
     *
     * @return array
     */
    public function getRegistrarData()
    {
        $rawRegistrarData = $this->get();

        $registrarData = [];
        foreach($rawRegistrarData as $key => $data)
        {
            $registrarData [$data->registrar] [$data->setting] = $this->decode($data->value);
        }

        return $registrarData;
    }

    /**
     * Estimate how many domains need a transfer.
     *
     * @return mixed
     */
    public function getDecodedValueAttribute()
    {
        return $this->decode($this->value);
    }

    public function decode($data)
    {
        return \localAPI('DecryptPassword', ['password2' => $data])['password'];
    }

}
