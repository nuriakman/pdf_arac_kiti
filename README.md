# PDF Araç Kiti

PDF Dosyaların üzerinde işlem yapmayı hedefleyen bir uygulamanın ekran tasarımı çalışması.

### Eklenebilecek Özellikler:
- Her biri X yapraktan oluşan kitapçık (booklet) yap
- Sayfa No Ekleme: Baş.Sayfa: X, Bit.Sayfa: Y,  Sayfa numarası şundan başlasın: Z  `pspdftool 'number(x=-1pt,y=-1pt,start=1,size=10)' input.pdf output.pdf` Kaynak: https://stackoverflow.com/a/9034911/134739


### Faydalı Programlar

- https://pdfkit.org/
- [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/)
- https://github.com/mstamy2/PyPDF2 A utility to read and write PDFs with Python
- https://github.com/pmaupin/pdfrw  pdfrw is a pure Python library that reads and writes PDFs


# ARAŞTIRMALAR


### pdftk Kullanım Örnekleri
- https://www.pdflabs.com/docs/pdftk-man-page/
- pdftk A=rapor.pdf B=bos.pdf cat B1 A3-7 B1 A9-10 B1 A9 output SONUC.pdf
- pdftk A=rapor.pdf B=bos.pdf cat A1 A1left A1right  A3-7 B1 A9-10 B1 A9 output SONUC.pdf


### jpg Yapma Kullanım Örnekleri
- https://stackoverflow.com/questions/6605006/convert-pdf-to-image-with-high-resolution#6605085
- convert -density 600 test.pdf -background white -flatten -resize 25% test.png
- convert -density 300 -trim test.pdf -quality 100 test.jpg
- convert demo.pdf[0] -scale x800 -quality 75  -flatten demo75.jpg
- convert -geometry 1600x1600 -density 200x200 -quality 100 test.pdf test_image.jpg
- convert -thumbnail x300 demo.pdf[2] -flatten demo.jpg
- -flatten Parametresi, transperant zemine sahip sayfaların düzgün çalışmasını sağlar
- Resimlerden PDF üretme `convert "*.{png,jpeg}" -quality 100 outfile.pdf`
- Resimlerden PDF üretme ÖNCE: `ls *.tif | xargs -I% convert % %.pdf` SONRA `pdftk *.pdf cat output merged.pdf && rm *.tif.pdf`
- PDF'den Resim Üretme: `convert -density 600 in.pdf out-%02d.jpg`

```BASH
# normally I extract the embedded image with 'pdfimages' at the native resolution, 
# then use ImageMagick's convert to the needed format:

pdfimages -list fileName.pdf
pdfimages fileName.pdf fileName   # save in .ppm format
convert fileName-000.ppm fileName-000.png

#this generate the best and smallest result file.

#Note: For lossy JPG embedded images, you had to use -j:

pdfimages -j fileName.pdf fileName   # save in .jpg format

```

veya

```BASH
convert           \
   -verbose       \
   -density 150   \
   -trim          \
    test.pdf      \
   -quality 100   \
   -flatten       \
   -sharpen 0x1.0 \
    24-18.jpg
```
Kaynak: https://stackoverflow.com/a/6605085/134739


The following extracts all images from a PDF file, saving them in JPEG format.
```
pdfimages -list in.pdf
pdfimages -j    in.pdf /tmp/out
pdfimages -all  in.pdf /tmp/out
```

If what you need is a cropped image in pdf/eps format, then extract a page with the image using pdfmod
```
pdfcrop --margins "-15 -50 0 -140" extracted_page.pdf
```

mkdir images && pdftoppm -jpeg -jpegopt quality=100 -r 300 mypdf.pdf images/pg


- Pdfimages reads the PDF file PDF-file, scans one or more pages, and writes one PPM, PBM, or JPEG file for each image.
- pdfimages -all input.pdf images/prefix


### Booklet Yapma:
- http://www.michaelm.info/blog/?p=1375
- http://pdfbooklet.sourceforge.net/


### HowTo Add Page Numbers to a PDF File:
- http://forums.debian.net/viewtopic.php?t=30598
- https://stackoverflow.com/questions/30378713/modify-existing-pdf-to-add-page-n-of-nnn-footer

The next command uses `pdftk` with `multistamp` to overlay the page numbering file to an original:
```
pdftk original.pdf              \
  multistamp 100pagenumbers.pdf \
  output pages-numbered.pdf
```

### Print two A5 pages on one A4 page with correct sizes:
### How can I print a PDF document on multiple pages?:
- https://askubuntu.com/questions/1143795/print-two-a5-pages-on-one-a4-page-with-correct-sizes
- https://askubuntu.com/questions/186867/how-can-i-print-a-pdf-document-on-multiple-pages
- https://pypi.org/project/pdfnup/
- https://pypi.org/project/pyPdf/
- https://pypi.org/project/PyPDF2/
- https://mstamy2.github.io/PyPDF2/
- http://pybrary.net/pyPdf/


### PDF to JPG:
- https://github.com/pankajr141/pdf2jpg
- convert myfile.pdf myfile.png
- magick myfile.pdf myfile.png
- pdfimages my-file.pdf prefix 
- pdftoppm input.pdf outputname -png    ----> imagemagick den daha kaliteli. pdftoppm is much faster than convert
- pdftk document.pdf cat 12 output - | convert - document-page-12.png


### PDF Poster Yapma:
- https://gitlab.com/pdftools/pdfposter
- https://pdfposter.readthedocs.io/en/stable/index.html


### Linux'daki PDF Yazılımları:
- https://en.wikipedia.org/wiki/List_of_PDF_software#Linux_and_Unix
- https://manpages.ubuntu.com/manpages/bionic/man1/pdftocairo.1.html
- https://www.mankier.com/1/pdftocairo
- https://github.com/DavidFirth/pdfjam
- https://poppler.freedesktop.org/
