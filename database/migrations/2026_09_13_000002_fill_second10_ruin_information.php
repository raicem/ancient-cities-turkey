<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('ruins')->where('id', 33)->update([
            'information' => 'One of the Bible\'s Seven Churches of Revelation. After a great earthquake it rebuilt itself and refused Rome\'s money.',
            'information_tr' => 'İncil\'deki Yedi Kilise\'den biri. Büyük depremden sonra kendi imkânlarıyla ayağa kalkmış, Roma\'nın parasını reddetmiştir.',
        ]);

        DB::table('ruins')->where('id', 38)->update([
            'information' => 'Its market hall carries Emperor Diocletian\'s maximum-price list carved in stone, the ancient world\'s price tag wall. The Temple of Zeus dominates the valley skyline.',
            'information_tr' => 'Pazar binasının duvarlarında İmparator Diocletianus\'un tavan fiyat listesi taşa kazılıdır; antik dünyanın etiket duvarı. Zeus Tapınağı vadinin siluetine hâkimdir.',
        ]);

        DB::table('ruins')->where('id', 52)->update([
            'information' => 'Sanctuary of Hecate, goddess of magic and witchcraft. Its carved friezes are now in the Istanbul Archaeology Museum.',
            'information_tr' => 'Büyü ve cadılık tanrıçası Hekate\'nin kutsal alanı. Kabartmalı frizleri bugün İstanbul Arkeoloji Müzesi\'ndedir.',
        ]);

        DB::table('ruins')->where('id', 53)->update([
            'information' => 'A king named it for his wife Stratonike, then gave her up to his lovesick son. Rare among ruins, it is still inhabited today.',
            'information_tr' => 'Bir kral kente karısı Stratonike\'nin adını vermiş, sonra onu oğluna bırakmıştır. Eskihisar köyü antik kentin içinde yaşamaya devam etmektedir.',
        ]);

        DB::table('ruins')->where('id', 54)->update([
            'information' => 'Tomb of King Mausolus and one of the Seven Wonders of the Ancient World. Every grand tomb since is named after him: mausoleum.',
            'information_tr' => 'Kral Mausolos\'un mezarı ve Antik Dünyanın Yedi Harikasından biri. O günden beri her büyük anıt mezara onun adıyla mozole denir.',
        ]);

        DB::table('ruins')->where('id', 78)->update([
            'information' => 'Famous for the rock tombs staring down at Dalyan river boats. Its kings were buried in temple-shaped graves carved into the cliff.',
            'information_tr' => 'Dalyan teknelerine bakan kayaya oyulmuş mezarlarıyla ünlüdür. Krallar, kayalığa oyulmuş tapınak cepheli mezarlara gömülmüştür.',
        ]);

        DB::table('ruins')->where('id', 79)->update([
            'information' => 'Capital of Lycia. Its assembly hall is the world\'s oldest known parliament building.',
            'information_tr' => 'Likya\'nın başkenti. Meclis binası, dünyanın bilinen en eski parlamento binasıdır.',
        ]);

        DB::table('ruins')->where('id', 80)->update([
            'information' => 'A port city with three harbors, founded by colonists from Rhodes. Alexander the Great spent a winter here on his Anatolian campaign.',
            'information_tr' => 'Rodoslu kolonicilerin kurduğu, üç limanlı bir liman kenti. Büyük İskender Anadolu seferinde bir kışı burada geçirmiştir.',
        ]);

        DB::table('ruins')->where('id', 103)->update([
            'information' => 'Physician Dioscorides was born here; his herbal encyclopedia guided medicine for 1,500 years. It later became capital of the Roman province of Cilicia Secunda.',
            'information_tr' => 'Hekim Dioskorides burada doğmuştur; bitki ansiklopedisi 1.500 yıl boyunca tıbba yol göstermiştir. Daha sonra Roma\'nın Kilikya Secunda eyaletine başkent olmuştur.',
        ]);

        DB::table('ruins')->where('id', 142)->update([
            'information' => 'Themistocles, the Athenian who saved Greece at Salamis, ended his life here as a Persian governor. Its Temple of Artemis was among the largest ever built.',
            'information_tr' => 'Salamis\'te Yunanistan\'ı kurtaran Atinalı Themistokles ömrünü burada Pers valisi olarak tamamlamıştır. Artemis Tapınağı, yapılmış en büyük tapınaklardandır.',
        ]);
    }

    public function down(): void
    {
        // Data-only fill, intentionally not reversible.
    }
};
