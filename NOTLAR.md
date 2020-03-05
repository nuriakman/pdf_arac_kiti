##  TODO
- Parola korumalı dosyalar
- Dosyaya parola koyma
- Dosyayadan parola kaldırma


## Faydalı Kaynaklar
- https://www.pdflabs.com/docs/pdftk-man-page/
- https://net2.com/how-to-install-and-use-pdftk-on-linux-to-merge-or-split-pdf-files/
- https://askubuntu.com/questions/1028522/how-can-i-install-pdftk-in-ubuntu-18-04-and-later


## BİRLEŞTİRME (Dosyaları birbirinin ardına ekleyerek)
```
pdftk 

	A=PDFs/Renk1.pdf 
	B=PDFs/Renk2.pdf 

cat 

	A
	B 

output 

	SONUC.pdf
```

## BİRLEŞTİRME (Bazı sayfaları alarak)
```
pdftk 

	A=PDFs/Renk1.pdf 
	B=PDFs/Renk2.pdf 

cat 

	A1 
	B2 
	A3 
	B4 

output 

	SONUC.pdf
```

## HER SAYFAYI AYRI AYRI PDF YAPMA
```
pdftk
	Renk1.pdf
	burst
```

## SAYFA SİLME
```
pdftk 
	
	A=PDFs/Renk1.pdf 

cat 

	A1
	A5-10
	A20-end

output 

	SONUC.pdf
```
