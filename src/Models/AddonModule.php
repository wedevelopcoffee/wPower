<?php
namespace WeDevelopCoffee\wPower\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Punic\Exception;

/**
 * Addon model
 */
class AddonModule extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbladdonmodules';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['decodedValue'];

    public $timestamps = false;

    /**
     * List all Modules.
     *
     * @return mixed
     */
    public function listAddons()
    {
        return self::groupBy('module');
    }

    /**
     * Fetch all module data for all modules
     *
     * @return array
     */
    public function getAddonData()
    {
        $rawAddonData = $this->get();

        $addonData = [];
        foreach($rawAddonData as $key => $data)
        {
            $addonData [$data->module] [$data->setting] = $this->decode($data->value);
        }

        return $addonData;
    }

    /**
     * Fetch all module data for the specific module and decode.
     *
     * @return array|string
     */
    public function getByKey($module, $key, $defaultValue = '')
    {
        $data = self::where('module', $module)
            ->where('setting', $key)
            ->first();

        $result = self::decode($data->value);

        if($result == '')
        {
            // on or off typically reflect a yesno type of field.
            if($defaultValue == 'on' || $defaultValue == 'off')
                return 'off';
            else
                return $defaultValue;
        }

        return $result;
    }

    /**
     * Update the module key value.
     *
     * @return array|string
     */
    public function updateByKey($module, $key, $value = '')
    {
        $value = self::encode($value);
        try {
            $data = self::where('module', $module)
                ->where('setting', $key)
                ->firstOrFail();
        } catch ( ModelNotFoundException $e)
        {
            // Create the record.
            $data = new AddonModule();
            $data->module = $module;
            $data->setting = $key;
        }

        $data->value = $value;
        $data->save();

        return true;
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

    /**
     * Decode the retrieved data.
     *
     * @param $data
     * @return mixed
     */
    protected function decode($data)
    {
        return html_entity_decode(\localAPI('DecryptPassword', ['password2' => $data])['password']);
    }

    /**
     * Decode the retrieved data.
     *
     * @param $data
     * @return mixed
     */
    protected function encode($data)
    {
        return html_entity_decode(\localAPI('EncryptPassword', ['password2' => $data])['password']);
    }

}
