import React from 'react';
import { Link } from 'react-router-dom';
import { FormattedMessage } from 'react-intl';

export default function AboutTr() {
  return (
    <div className="info-bar">
      <div>
        <Link href="/" to="/">
          <button className="button button-red close-button" id="close">
            <FormattedMessage id="close" />
          </button>
        </Link>
      </div>
      <h3>Bu Proje Hakkında</h3>
      <p>
        Türkiye'nin tüm antik kentlerini bir harita üzerinde görmek istedim. Böylece yakınlarda ne
        var ne yok görebilecek ve ona göre seyahat edebilecektim. İstediğime yakın bir şey
        bulamadığımdan dolayı, bu siteyi yapmaya başladım. Şu anda sitede 110 adet ören yeri
        bulunmakta. Ancak tahminlerime göre bu sayı 140'a kadar çıkabilir. Yani hala ekleyecek bolca
        nokta var.
      </p>
      <p>
        Proje hakkında daha fazla bilgi almak isterseniz{' '}
        <a href="https://raicem.github.io/2017/08/28/turkiyenin-antik-kentleri/">
          blog yazımı
        </a>{' '}
        ziyaret edebilirsiniz.
      </p>
      <p>
        Topladığım verilerin doğruluğuna özen gösterdim ancak bu konular hakkında herhangi bir resmi
        eğitimim olmadığı için, lütfen bazı bilgilerin güncel veya doğru olmayabileceğini göz önünde
        bulundurun.
      </p>
      <p>
        Sitedeki hata bildir formundan, <a href="https://twitter.com/ciftehavuz">Twitter'dan </a>
        veya <a href="mailto:unalancem@gmail.com">unalancem@gmail.com</a> adresinden bana
        ulaşabilirsiniz.
      </p>
    </div>
  );
}
