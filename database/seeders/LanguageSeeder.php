<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang_all = Config::get('languages');

        foreach ($lang_all as $language) {
            $country = Country::query()->where('name', $language['country']);
            if (
                !$country->exists()
            ) {
                $country = new Country([
                    'name' => $language['country']
                ]);
                $country->save();
            } else {
                $country = $country->first();
            }

            foreach ($language['languages'] as $lang) {
                $langValid = Language::query()->where('name', $lang);
                $idCountry = $country->id;
                if (!$langValid->exists()) {
                    $langSave = new Language([
                        'name' => $lang,
                        'country_id' => $idCountry
                    ]);
                    $langSave->save();
                }
            }
        }
    }
}
