<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('ruins')->where('id', 6)->update([
            'information_tr' => 'Roma dönemine kadar uzanan bir kale.',
        ]);

        DB::table('ruins')->where('id', 42)->update([
            'information' => 'The ancient city of Prusias ad Hypium lies in the Bithynia region. Today it is within the borders of Düzce.',
        ]);

        DB::table('ruins')->where('id', 43)->update([
            'information' => 'Today it lies within the Eskipazar district of Karabük province. It was founded after 323 BC, the death of Alexander. Eskipazar fell within the Paphlagonian state, one of the new states formed after the breakup of the Macedonian Empire.',
        ]);

        DB::table('ruins')->where('id', 92)->update([
            'information' => 'Alacahöyük is a mound at Hüyük village, 15 km northwest of Alaca district in Çorum. 15 settlement or building layers from four distinct cultural phases have been identified in this mound.',
        ]);

        DB::table('ruins')->where('id', 99)->update([
            'information' => 'Today it lies at Karacaören, north of Lake Eğirdir. Numismatic sources connect the founding or liberation of the city to Alexander the Great.',
        ]);
    }

    public function down(): void
    {
        // Data-only fill, intentionally not reversible.
    }
};
