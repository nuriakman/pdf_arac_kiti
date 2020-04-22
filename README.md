# PDF Araç Kiti

PDF Dosyaların üzerinde bir çok işlem yapmayı hedefleyen bir PHP uygulamasıdır.

## İşte Yapabilecekleriniz !
- Birden fazla PDF dosyayı birleştirme
  - Tek tek dosya seçebilme
  - Toplu dosya seçebilme ve sıralamasını değiştirebilme
  - Eklenen her dosya sağ sayfadan başlasın
  - Dosyalar arasına 1 boş sayfa ekleme
  - Dosyalar arasına 2 boş sayfa ekleme
- PDF Dosya içinden sayfa silme
  - Çoklu dosya seçimi veya bir adet dosya seçimi
  - PDF dosya içindeki belirtilen sayfaları silme (tekli sayfa ve aralıklı seçim yapabilme)
  - Sadece şu sayfaları bırak, diğerlerini sil (tekli sayfa ve aralıklı seçim yapabilme)
  - TEK sayfaların hepsini sil 
  - ÇİFT sayfaların hepsini sil
- PDF Dosyayı Böl
  - Her sayfayı ayrı PDF yap 
  - Her x adet sayfayı alıp, ayrı PDF'ler yap
  - Şu sayfalardan başlayıp böl ve ayrı PDF'ler yap
  - Şu sayfaları alarak böl (Her ';' ayrımı, ayrı bir PDF olacak) (tekli sayfa ve aralıklı seçim yapabilme)
- PDF'den Resim'e Döüştürme
  - Çoklu dosya seçimi veya bir adet dosya seçimi
  - PDF içindeki tüm resimleri çıkar 
  - PDF'in her sayfasını JPG dosyası olarak çıkar (ayrıca JPG kalitesi seçebilme)
- Resim'den PDF'e Dönüştürme
  - Çoklu dosya seçimi veya bir adet dosya seçimi
  - Resimlerin her birini PDF dosya yap 
  - Resimlerden bir tane PDF dosya yap 
  - A4 Kağıt Yönü belirleme (yatay, dikey)
- PDF Dosyaları Harmanla
  - Çoklu dosya seçimi veya bir adet dosya seçimi
  - Kaç sayfa alınarak harmanlansın seçimi
  - Harmanlamaya kaçıncı sayfadan başlasın seçimi
  - Her hamanlama turu ayrı bir PDF olsun
  - Tümünü tek dosyaya harmanla
- PDF Dosyanın Arasına PDF Ekle
  - Ana PDF dosyasını seçme
  - Ana PDF dosyanızın içine eklenecek PDF Dosyalası seçme
  - Hangi sayfadan sonra ekleme yapılacağının seçimi
  - Eklenecek dosyanın hangi sayfalarının alınacağının seçimi (tekli sayfa ve aralıklı seçim yapabilme)
- Sayfaları Düzenle  
  - Ana PDF dosyasını seçme
  - Sayfaların tümünü pul fotoğraf (thumbnail) olarak görme
  - Pul fotoğrafa tıklatıp sayfayı daha büyük görebilme
  - Silinecek sayfaları işaretleyebilme
  - Sayfayı +90 Derece çevirme
  - Sayfayı -90 Derece çevirme
  - Sayfayı +180 Derece çevirme
  - Sürükle bırak yaparak sayfaların sıralamasını değiştirebilme


## Kullanılan Kütüphaneler
- [pdftk](https://www.pdflabs.com/docs/pdftk-man-page/)
- [pdftoppm](https://linux.die.net/man/1/pdftoppm)
- [pdfimages](https://www.mankier.com/1/pdfimages)
- [convert](https://imagemagick.org/script/convert.php)
- [img2pdf](https://gitlab.mister-muffin.de/josch/img2pdf)
- [poppler-utils](https://www.mankier.com/package/poppler-utils) 

## DigitalOcean Droplet'inde kurulum işlemi

UBUNTU 18.08, 1 Gb RAM ve 1 CPU için test edildi.

```
apt update
apt upgrade -y
apt install git  -y
apt autoremove -y
apt install imagemagick -y
apt install img2pdf -y
apt install poppler-utils -y
apt install apache2 -y
apt install php7.2 -y
apt install php7.2-fpm -y
apt install php-bcmath php-bz2 php-intl php-gd php-mbstring php-zip -y

a2enconf php7.2-fpm
service apache2 restart
a2enmod php7.2

sudo add-apt-repository ppa:malteworld/ppa -y
sudo apt update
sudo apt install pdftk -y

chown -R www-data:www-data /var/www/html/
rm /var/www/html/index.html

cd /var/www/html/
git clone https://github.com/nuriakman/pdf_arac_kiti.git .

mkdir /var/www/html/upload
chown -R www-data:www-data /var/www/html/upload
chmod -R +w /var/www/html/upload

```