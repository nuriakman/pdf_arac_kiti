# PDF Araç Kiti

PDF Dosyaların üzerinde işlem yapmayı hedefleyen bir uygulamanın ekran tasarımı çalışması.

## Projede kullanılan ek paketler
pdftk
pdftoppm
pdfimages
convert
img2pdf

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