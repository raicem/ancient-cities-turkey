<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('ruins')->where('id', 34)->update([
            'information' => 'A mountain city at 1,500 meters, abandoned after earthquakes. Its Antonine Fountain was restored and flows again today.',
            'information_tr' => 'Denizden 1.500 metre yüksekte bir dağ kenti; depremlerden sonra terk edilmiştir. Restore edilen Antoninler Çeşmesi bugün yeniden akmaktadır.',
        ]);

        DB::table('ruins')->where('id', 48)->update([
            'information' => 'Capital of Phrygia and home of King Midas. Alexander the Great cut the famous Gordian knot here.',
            'information_tr' => 'Frigya\'nın başkenti ve Kral Midas\'ın yurdu. Büyük İskender ünlü Gordion düğümünü burada kesmiştir.',
        ]);

        DB::table('ruins')->where('id', 49)->update([
            'information' => 'One of the world\'s oldest settlements, 9,000 years old, with no streets or doors. People entered their houses through holes in the roof.',
            'information_tr' => '9 bin yıllık, dünyanın en eski yerleşimlerinden biri. Sokak ve kapı yoktu; insanlar evlerine çatıdaki deliklerden girerdi.',
        ]);

        DB::table('ruins')->where('id', 56)->update([
            'information' => 'Federal sanctuary of ancient Lycia, dedicated to Leto and her twins Apollo and Artemis. A trilingual inscription found here unlocked the lost Lycian language.',
            'information_tr' => 'Antik Likya\'nın federal kutsal alanı; Leto ile ikizleri Apollon ve Artemis\'e adanmıştır. Burada bulunan üç dilli yazıt, kayıp Likya dilinin çözülmesini sağlamıştır.',
        ]);

        DB::table('ruins')->where('id', 57)->update([
            'information' => 'Capital of ancient Lycia. Twice in its history the whole city chose mass suicide over surrender, first against the Persians and later against the Romans.',
            'information_tr' => 'Antik Likya\'nın başkenti. Tarihinde iki kez kentin tamamı teslim olmak yerine toplu intiharı seçmiştir; önce Perslere, sonra Romalılara karşı.',
        ]);

        DB::table('ruins')->where('id', 68)->update([
            'information' => 'The world\'s oldest known temple complex, built by hunter-gatherers around 9600 BC, thousands of years before agriculture or writing existed.',
            'information_tr' => 'Dünyanın bilinen en eski tapınak kompleksi. Tarım ve yazıdan binlerce yıl önce, MÖ 9600 civarında avcı-toplayıcılar tarafından inşa edilmiştir.',
        ]);

        DB::table('ruins')->where('id', 70)->update([
            'information' => 'Some of the world\'s oldest metal swords were found here, alongside one of the earliest known palace complexes.',
            'information_tr' => 'Dünyanın bilinen en eski saray komplekslerinden biri buradaydı ve en eski metal kılıçlardan bazıları bu kalıntılarda bulunmuştur.',
        ]);

        DB::table('ruins')->where('id', 71)->update([
            'information' => 'Medieval capital of Armenia, once known as the city of 1001 churches. It sits right on the closed Turkish-Armenian border.',
            'information_tr' => 'Orta Çağ\'da Ermenistan\'ın başkentiydi ve bir zamanlar 1001 kiliseli şehir olarak bilinirdi. Türkiye-Ermenistan sınırında yer alır.',
        ]);

        DB::table('ruins')->where('id', 77)->update([
            'information' => 'The ancient world\'s second-greatest oracle after Delphi. Kings and generals came here to ask Apollo about the future.',
            'information_tr' => 'Delphi\'den sonra antik dünyanın en büyük ikinci kehanet merkezi. Krallar ve generaller geleceği sormak için Apollon\'a buraya gelirdi.',
        ]);

        DB::table('ruins')->where('id', 83)->update([
            'information' => 'Once a notorious pirate base and one of the ancient world\'s biggest slave markets. The seaside Temple of Apollo is now its postcard view.',
            'information_tr' => 'Bir zamanlar kötü şöhretli bir korsan üssü ve antik dünyanın en büyük köle pazarlarından biriydi. Deniz kenarındaki Apollon Tapınağı bugün şehrin simgesidir.',
        ]);
    }

    public function down(): void
    {
        // Data-only fill, intentionally not reversible.
    }
};
