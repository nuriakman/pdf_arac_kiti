##  TODO
- Parola korumalı dosyalar
- Dosyaya parola koyma
- Yazdırma engeli koyma
- Dosyayadan parola kaldırma
- PDF Dosya tamir etme  pdftk broken.pdf output fixed.pdf
- Uncompress PDF page streams for editing the PDF in a text editor (e.g., vim, emacs) pdftk doc.pdf output doc.unc.pdf uncompress

* Merge PDF Documents
* Collate PDF Page Scans
* Split PDF Pages into a New Document
* Rotate PDF Documents or Pages
* Decrypt Input as Necessary (Password Required)
* Encrypt Output as Desired
* Fill PDF Forms with X/FDF Data and/or Flatten Forms
* Generate FDF Data Stencils from PDF Forms
* Apply a Background Watermark or a Foreground Stamp
* Report PDF Metrics, Bookmarks and Metadata
* Add/Update PDF Bookmarks or Metadata
* Attach Files to PDF Pages or the PDF Document
* Unpack PDF Attachments
* Burst a PDF Document into Single Pages
* Uncompress and Re-Compress Page Streams
* Repair Corrupted PDF (Where Possible)
 


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
output
	Renk_%04d.pdf
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
