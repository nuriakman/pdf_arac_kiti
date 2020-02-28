<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDF Araç Kiti</title>
</head>

<body>
    <h1>PDF Araç Kiti</h1>
    <br>
    <br>

    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- ======================= BİRLEŞTİR ======================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formBirlestir" name="formBirlestir" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formBirlestir">
        
        <h2>PDF Dosyaları Birleştir</h2>
        
        <fieldset>
            <legend><b style='color: darkred;'>Tek Tek PDF Dosya Seçimi:</b> <input type='button' value='1 PDF Daha Ekle' onclick='YeniDosyaEkle(1)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" id="tableBirlestirme1">
                <tr>
                    <td nowrap="nowrap"> Dosya No </td>
                    <td nowrap="nowrap"> Birleştirilecek PDF dosyayı seçiniz </td>
                    <td nowrap="nowrap"> Bu dosyanın hangi sayfaları alınsın? </td>
                </tr>
                
                <tr style='display:none;'>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        YENİ
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='DosyalarTekli[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='AlinacakSayfalar[]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        1
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='DosyalarTekli[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='AlinacakSayfalar[]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>


                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        2
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='DosyalarTekli[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='AlinacakSayfalar[]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>

            </table>
            <p><b>NOT:</b> Dosyalarınız farklı farklı klasörler içindeyse bu bölümü kullanarak teker teker ekleyebilirsiniz</p>
        </fieldset>


        <fieldset>
            <legend><b style='color: darkred;'>Çoklu PDF Dosya Seçimi:</b> </legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Birleştirilecek Dosyaları Seçiniz (Çoklu Seçim) </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='DosyalarCoklu[]' id='DosyalarCoklu' multiple onchange='DosyalariEkranaListele()'> </td>
                </tr>
                <tr id='SiralamaSatiri' style='display:none;'>
                    <td colspan="2">
                        <b>Dosyalarınızın sıralamasını sürükle-bırak yaparak değiştirebilirsiniz:</b><br>
                        <input type='hidden' id='BirlestirmeSiralama' name='BirlestirmeSiralama' value=''>
                        <ul id='tmpSecilenDosyalar' class='tmpSecilenDosyalar'>
                            
                        </ul>
                    </td>
                </tr>
            </table>
            <p><b>NOT:</b> Dosyalarınızın tamamı tek bir klasör içindeyse bu bölümü kullanarak bir defada ve kolayca ekleyebilirsiniz</p>
        </fieldset>

        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyaları Birleştirme Ayarları:</b> </legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Eklenen her dosya sağ sayfadan başlasın </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarBirlestir1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Dosyalar arasına boş bir yaprak ekle </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarBirlestir2"> </td>
                </tr>
            </table>
        </fieldset>



        <input type="button" value="Birleştir" onclick="FormuPostala('formBirlestir')" id="FormuGonder">
    </form>



    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- =========================== BÖL ========================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formBol" name="formBol" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formBol">
        
        <h2>PDF Dosyayı Böl</h2>
        
        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosya1[]'> </td>
                </tr>
            </table>
        </fieldset>


        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyayı Bölme Seçenekleri:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Her sayfayı ayrı PDF yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarBol1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Her X sayfayı alıp, ayrı PDF'ler yap </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarBol2" style="width: 250px;" placeholder="Örnek: 4"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Şu sayfalardan bölerek ayrı PDF'ler yap </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarBol3" style="width: 250px;" placeholder="Örnek: 6,18,27,33"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Özel böl (Her ';' ayrımı ayrı bir PDF olacak) </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarBol4" style="width: 250px;" placeholder="Örnek: 1,7,10,50-60;18-30,35-40"> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Böl" onclick="FormuPostala('formBol')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- =========================== RESİM ======================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formResim1" name="formResim1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formResim1">
        
        <h2>PDF'den Resim'e</h2>
        
        <fieldset>
            <legend><b style='color: darkred;'>PDF'den Resim Üret:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosya1[]'> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> PDF içindeki tüm resimleri çıkar </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResimPDFYap1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> PDF'in her sayfasını resim dosyası olarak çıkar </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResimPDFYap2"> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Başla !" onclick="FormuPostala('formResim1')" id="FormuGonder">
    </form>



    <form id="formResim2" name="formResim2" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formResim2">

        <h2>Resim'den PDF'e</h2>

        <fieldset>
            <legend><b style='color: darkred;'>Resim'den PDF üret: (Sadece jpg ve png)</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Resim Dosyalarını Seçiniz (Çoklu Seçim)</td>
                    <td nowrap="nowrap">
                        <input accept='image/jpeg,image/png' type='file' name='AnaDosya1[]' multiple> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Resimlerin her birini PDF dosya yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResim1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Resimlerden PDF dosya yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResim2"> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Başla !" onclick="FormuPostala('formResim2')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- ======================= HARMANLA ========================= -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formHarmanla" name="formHarmanla" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formHarmanla">

        <h2>PDF Dosyaları Harmanla</h2>

        <fieldset>
            <legend><b style='color: darkred;'>Harmanlanacak PDF Dosyalarınızı Ekleyin:</b>  <input type='button' value='1 PDF Daha Ekle' onclick='YeniDosyaEkle(3)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" id="tableBirlestirme3">
                <tr>
                    <td nowrap="nowrap"> Dosya</td>
                    <td nowrap="nowrap"> Harmanlanacak PDF: </td>
                    <td nowrap="nowrap"> Kaç sayfa alınarak harmanlansın? </td>
                    <td nowrap="nowrap"> Harmanlamaya kaçıncı sayfadan başlasın? </td>
                </tr>

                <tr style='display:none;'>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        YENİ
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='HarmanPDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_AlinacakSayfalar[]' value='' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_BaslamaSayfasi[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
                    </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        1
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='HarmanPDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_AlinacakSayfalar[]' value='' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_BaslamaSayfasi[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
                    </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        2
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='HarmanPDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_AlinacakSayfalar[]' value='' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_BaslamaSayfasi[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
                    </td>
                </tr>

            </table>
        </fieldset>
        <input type="button" value="Harmanla" onclick="FormuPostala('formHarmanla')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- ======================= ARAYA EKLE ======================= -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formArayaEkle" name="formArayaEkle" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formArayaEkle">

        <h2>PDF Dosyanın Arasına PDF Ekle</h2>

        <fieldset>
            <legend><b style='color: darkred;'>Ana PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosya1[]' multiple> </td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend><b style='color: darkred;'>Ana PDF Dosyanızın İçine PDF Dosya Ekleyin:</b>  <input type='button' value='1 PDF Daha Ekle' onclick='YeniDosyaEkle(2)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" id="tableBirlestirme2">
                <tr>
                    <td nowrap="nowrap"> Dosya</td>
                    <td nowrap="nowrap"> Hangi sayfadan sonra? </td>
                    <td nowrap="nowrap"> Eklenecek PDF </td>
                    <td nowrap="nowrap"> Bu dosyanın hangi sayfaları alınsın? </td>
                </tr>

                <tr style='display:none;'>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        YENİ
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Baslama[]' style='width: 300px;' placeholder='Örnek: 18 (Sonuna eklemek için boş bırakın)'>
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='YeniPDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[]' style='width: 250px;' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)'>
                    </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        1
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Baslama[]' style='width: 300px;' placeholder='Örnek: 18 (Sonuna eklemek için boş bırakın)'>
                    </td>
                    <td nowrap='nowrap'>
                        <input accept='application/pdf' type='file' name='YeniPDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[]' style='width: 250px;' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)'>
                    </td>
                </tr>

            </table>
        </fieldset>
        <input type="button" value="Araya Ekle" onclick="FormuPostala('formArayaEkle')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- ========================== YONET ========================= -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formYonet1" name="formYonet1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formYonet1">

        <h2>Sayfaları Düzenle</h2>

        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosya1[]'> </td>
                    <td nowrap="nowrap"> 
                        <input type="button" value="Başla !" onclick="FormuPostala('formYonet1')" id="FormuGonder"> </td>
                </tr>
            </table>
        </fieldset>
    </form>


    <form id="formYonet2" name="formYonet2" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="FormAdi" value="formYonet2">

        <h2>Sayfa Yönü Değiştir / Sırala</h2>

        <p>Sürükle bırakarak yaparak sayfaların yerlerini değiştirebilirsiniz.<br>Yeşil oklara tıklayarak sayfa yönünü değiştirebilirsiniz.</p>

        <fieldset>
            <legend><b style='color: darkred;'>SAYFALARI DÜZENLE</b></legend>

            <ul class="PDFSayfalari">
                
                <li>
                    <img id='0' src='pul/sayfa-0000.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='0'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL0' name='sol[0]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG0' name='sag[0]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK0' name='dik[0]'>
                    <div class='LabelYON' onclick="Cevir1(0, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(0, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(0, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: TEST</span>
                </li>
                
                <li>
                    <img id='1' src='pul/sayfa-0001.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='1'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL1' name='sol[1]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG1' name='sag[1]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK1' name='dik[1]'>
                    <div class='LabelYON' onclick="Cevir1(1, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(1, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(1, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 1</span>
                </li>
                
                <li>
                    <img id='2' src='pul/sayfa-0002.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='2'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL2' name='sol[2]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG2' name='sag[2]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK2' name='dik[2]'>
                    <div class='LabelYON' onclick="Cevir1(2, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(2, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(2, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 2</span>
                </li>
                
                <li>
                    <img id='3' src='pul/sayfa-0003.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='3'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL3' name='sol[3]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG3' name='sag[3]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK3' name='dik[3]'>
                    <div class='LabelYON' onclick="Cevir1(3, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(3, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(3, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 3</span>
                </li>
                
                <li>
                    <img id='4' src='pul/sayfa-0004.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='4'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL4' name='sol[4]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG4' name='sag[4]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK4' name='dik[4]'>
                    <div class='LabelYON' onclick="Cevir1(4, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(4, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(4, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 4</span>
                </li>
                
                <li>
                    <img id='5' src='pul/sayfa-0005.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='5'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL5' name='sol[5]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG5' name='sag[5]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK5' name='dik[5]'>
                    <div class='LabelYON' onclick="Cevir1(5, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(5, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(5, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 5</span>
                </li>
                
                <li>
                    <img id='6' src='pul/sayfa-0006.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='6'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL6' name='sol[6]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG6' name='sag[6]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK6' name='dik[6]'>
                    <div class='LabelYON' onclick="Cevir1(6, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(6, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(6, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 6</span>
                </li>
                
                <li>
                    <img id='7' src='pul/sayfa-0007.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='7'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL7' name='sol[7]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG7' name='sag[7]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK7' name='dik[7]'>
                    <div class='LabelYON' onclick="Cevir1(7, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(7, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(7, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 7</span>
                </li>
                
                <li>
                    <img id='8' src='pul/sayfa-0008.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='8'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL8' name='sol[8]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG8' name='sag[8]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK8' name='dik[8]'>
                    <div class='LabelYON' onclick="Cevir1(8, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(8, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(8, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 8</span>
                </li>
                
                <li>
                    <img id='9' src='pul/sayfa-0009.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='9'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL9' name='sol[9]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG9' name='sag[9]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK9' name='dik[9]'>
                    <div class='LabelYON' onclick="Cevir1(9, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(9, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(9, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 9</span>
                </li>
                
                <li>
                    <img id='10' src='pul/sayfa-0010.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='10'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL10' name='sol[10]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG10' name='sag[10]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK10' name='dik[10]'>
                    <div class='LabelYON' onclick="Cevir1(10, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(10, 'SAG', this.value)"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(10, 'DIK', this.value)"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 10</span>
                </li>
                
                <li>
                    <img id='11' src='pul/sayfa-0011.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='11'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL11' name='sol[11]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG11' name='sag[11]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK11' name='dik[11]'>
                    <div class='LabelYON' onclick="Cevir1(11, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(11, 'SAG')"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(11, 'DIK')"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 11</span>
                </li>
                
                <li>
                    <img id='12' src='pul/sayfa-0012.jpg'>
                    <input type='hidden' name='sayfa_no[]' value='12'>
                    <br>
                    <input type='checkbox' class='chkBoxGizli' id='SOL12' name='sol[12]'>
                    <input type='checkbox' class='chkBoxGizli' id='SAG12' name='sag[12]'>
                    <input type='checkbox' class='chkBoxGizli' id='DIK12' name='dik[12]'>
                    <div class='LabelYON' onclick="Cevir1(12, 'SOL')"> &#8630; </div>
                    <div class='LabelYON' onclick="Cevir1(12, 'SAG')"> &#8631; </div>
                    <div class='LabelYON' onclick="Cevir1(12, 'DIK')"> &#8645; </div>
                    <span class='SayfaNo'>Sayfa: 12</span>
                </li>
                
            </ul> <!-- /PDFSayfalari -->

            <br style='clear: both; '>
        </fieldset>

        <h2>Sayfa Sil / Boş Sayfa Ekle</h2>
        
        <fieldset>
            <legend><b style='color: darkred;'>Sayfa Sil / Boş Sayfa Ekle</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Hangi sayfalar silinsin? </td>
                    <td nowrap="nowrap"> Hangi sayfalardan sonra boş sayfa eklensin? </td>
                </tr>
                <tr>
                    <td nowrap="nowrap">
                        <input type="text" name="SilinecekSayfalar" placeholder="Örnek: 6,18,27,33-40" style="width: 250px;"> </td>
                    <td nowrap="nowrap">
                        <input type="text" name="EklenecekSayfalar" placeholder="Örnek: 6,18,27,33" style="width: 250px;"> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Değişiklikleri Kaydet" onclick="FormuPostala('formYonet2')" id="FormuGonder">
    </form>

    <p style="margin-bottom: 0px;">
        <input type="hidden" name="toplamsayfa" value="116">
        <input type="submit" name="gonder" value="SUBMIT">
        <input type="button" value="Ajax File Upload" onclick="HAYDI()">
    </p>

</body>

</html>






<style>
    body {
        background-color: #FFFFFF;
        margin: 0px;
        padding: 0px;
        margin-right:  10%;
        font-family: sans-serif;
        margin-bottom: 700px;
    }

    form {
        margin-bottom: 50px;
        margin-left:  20px;
        background-color:  white;
        border: none;
        padding:  5px;
    }

    fieldset {
        margin-bottom: 30px;        
    }

    #formBirlestir  {border-left: 15px solid #FF5722; padding-left: 20px; }
    #formBol        {border-left: 15px solid #FF9800; padding-left: 20px; }
    #formResim1     {border-left: 15px solid #FFEA00; padding-left: 20px; }
    #formResim2     {border-left: 15px solid #C6FF00; padding-left: 20px; }
    #formHarmanla   {border-left: 15px solid #00E676; padding-left: 20px; }
    #formArayaEkle  {border-left: 15px solid #00B0FF; padding-left: 20px; }
    #formYonet1     {border-left: 15px solid #651FFF; padding-left: 20px; }
    #formYonet2     {border-left: 15px solid #AA00FF; padding-left: 20px; }

    /* Taşınan Nesne */
    .drop-elmDrag {
        background-color: #1565C0;
    }

    /* Bırakılacak Konum */
    .tmpSecilenDosyalar li.drop-replacer {
      border: 1px dashed #000000;
      background: none;
      background-color: lightgreen;
    }

    /* PDF Sayfa Önizlemelerinin olduğu UL elementi */
    .tmpSecilenDosyalar {
        margin: 0px;
        padding: 0px;
    }

    /* Her bir PDF Sayfa Önizlemesi */
    .tmpSecilenDosyalar li {
        margin:  5px;
        list-style: none;
        overflow: hidden;
        border: 1px solid darkgrey;
        padding: 5px;
    }


/* ***************************************** */



    /* Bırakılacak Konum */
    .PDFSayfalari li.drop-replacer {
      border: 1px dashed #000000;
      background: none;
      background-color: lightgreen;
    }

    /* PDF Sayfa Önizlemelerinin olduğu UL elementi */
    .PDFSayfalari {
        margin: 0px;
        padding: 0px;
        cursor: grab;
    }

    /* Her bir PDF Sayfa Önizlemesi */
    .PDFSayfalari li {
        margin:  5px;
        list-style: none;
        width: 150px;
        height: 230px;
        text-align: center;
        float: left;
        overflow: hidden;
        border: 1px solid darkgrey;
        padding: 5px;
        display: block;
    }

    .PDFSayfalari img {
        margin: 5px;
        border: 1px solid lightgray;
        height: 150px;
    }

    .LabelYON {
        font-size: 25px;
        margin-left: 15px;
        background-color: #A5D6A7 !important;
        margin: 2px;
        display: inline-block;
        width: 30px !important;
        height: 30px !important;
        overflow: hidden;
        border-radius: 50px;
        border: 1px solid #33691E;
        cursor: pointer;
    }
    
    .SOL {
        transform: rotate(-90deg);
    }
    
    .SAG {
        transform: rotate( 90deg);
    }
    
    .DIK {
        transform: rotate( 180deg);
    }
    
    .NORMAL {
        transform: rotate( 0deg);
    }

    .chkBoxGizli {
        display:  none;
    }

    .SayfaNo {
        border-top: 3px solid #FF5722;
        padding-top:  2px;
        font-size:  15px !important;
        display: block;
        text-align: left;
    }


/* TYPE file */
/* TYPE file */
/* TYPE file */
input[type=file] {
  min-width: 100px;
  font-family: inherit;
  appearance: none;
  border: 0;
  border-radius: 5px;
  background: #FFE0B2;
  color: #000;
  padding: 8px 16px;
  font-size: 1rem;
  cursor: pointer;
}

input[type=file]:hover {
  background: #1d49aa;
}

input[type=file]:focus {
  outline: none;
  box-shadow: 0 0 0 4px #cbd6ee;
}

/* TYPE button */
/* TYPE button */
/* TYPE button */
input[type=button] {
  min-width: 100px;
  font-family: inherit;
  appearance: none;
  border: 0;
  border-radius: 5px;
  background: #4676d7;
  color: #fff;
  padding: 8px 16px;
  font-size: 1rem;
  cursor: pointer;
}

input[type=button]:hover {
  background: #1d49aa;
}

input[type=button]:focus {
  outline: none;
  box-shadow: 0 0 0 4px #cbd6ee;
}

/* TYPE text */
/* TYPE text */
/* TYPE text */
input[type=text] {
    padding:5px; 
    border:2px solid #ccc; 
    -webkit-border-radius: 5px;
    border-radius: 5px;
}

input[type=text]:focus {
    border-color:#333;
}

input[type=submit] {
  min-width: 100px;
  font-family: inherit;
  appearance: none;
  border: 0;
  border-radius: 5px;
  background: #F44336;
  color: #fff;
  padding: 8px 16px;
  font-size: 1rem;
  cursor: pointer;
}

    #FormuGonder    {
        min-width: 100px;
        font-family: inherit;
        appearance: none;
        border: 0;
        border-radius: 5px;
        color: #fff;
        padding: 8px 16px;
        font-size: 1.5rem;
        cursor: pointer;
        background-color: #E91E63;
        width: 300px;
    }


</style>




<script src="js/jquery-3.4.1.min.js"></script>
<script src="dropMe/dropMe.js"></script>
<!-- KAYNAK: http://naukri-engineering.github.io/dropMe/  -->

<script>

    jQuery(document).ready(function($) {
        $('.PDFSayfalari').dropme({
            // items: '.PDFSayfa'
        });
    });


    function YeniDosyaEkle(Kod) {
        var rowCount = $('#tableBirlestirme' +Kod+ ' tr').length;
        var SATIR = $('#tableBirlestirme' +Kod+ ' tr:nth-child(2)');
        SATIR.clone().appendTo('#tableBirlestirme' +Kod);
        $('#tableBirlestirme' +Kod+ ' tr:nth-child(' + (rowCount+1) + ')').show()
        var tr = $('#tableBirlestirme' +Kod+ ' tr:nth-child(' + (rowCount+1) + ')').find("td");
        tr[0].innerHTML = rowCount - 1;
    }


    function DosyalariEkranaListele() {
        var files = $('#DosyalarCoklu').get(0).files;

        if ( $('.tmpSecilenDosyalar li').length >= 1 ) {
            $('.tmpSecilenDosyalar').dropme('destroy');
            $('.tmpSecilenDosyalar').html('');
        }

        // Sürükle bırak eklenirse süper olur...
        // $('.tmpSecilenDosyalar').dropme();
        $.each(files, function(_, file) {
            //$('.tmpSecilenDosyalar').append( '<li>name : ' + file.name + ' --- ' + ' size : ' + file.size + '</li>' );
            $('.tmpSecilenDosyalar').append( '<li>' + file.name + '</li>' );
        });

        $('#SiralamaSatiri').hide();
        if ( $('.tmpSecilenDosyalar li').length > 1 ) {
            $('#SiralamaSatiri').show();
        }

        if ( $('.tmpSecilenDosyalar li').length >= 1 ) {

            $('#BirlestirmeSiralama').val('');
            $('.tmpSecilenDosyalar li').each(function(i, li){
                $('#BirlestirmeSiralama').val( $('#BirlestirmeSiralama').val() + '|' + $(li).text() );
            })

            $('.tmpSecilenDosyalar').dropme({
                replacerSize: true 
            });

            $('.tmpSecilenDosyalar').bind('sortupdate', function(e, elm) {
                //Triggered when the position has changed.
                $('#BirlestirmeSiralama').val('');
                $('.tmpSecilenDosyalar li').each(function(i, li){
                    $('#BirlestirmeSiralama').val( $('#BirlestirmeSiralama').val() + '|' + $(li).text() );
                })

                // $('#BirlestirmeSiralama').html()
            });

        }

        return;
    }

    function HAYDI() {

        // AJAX ile FİLE UPLOAD

        var form = $('#form1')[0]; // You need to use standard javascript object here
        var data = new FormData(form);
        data.append("CustomField1", "This is some extra data, testing");
        data.append("CustomField2", "This is some extra data, testing");
        // Attach file
        data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url    : '1test.php',
            type   : 'POST',
            enctype: 'multipart/form-data',
            data   : data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            dataType: "text",
           success : function(ajaxCevap)
           {
               alert(ajaxCevap); // Cevabı göster...
           }
        } );
    }


    function Cevir(ResimNo, ResimYon) {
        // console.log(ResimNo, ResimYon, DEGER)
        document.getElementById(ResimNo).className = 'NORMAL';
        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            document.getElementById(ResimNo).className = ResimYon;
        }
    }

    function Cevir1(ResimNo, ResimYon) {
        // console.log(ResimNo, ResimYon, DEGER)
        document.getElementById(ResimNo).className = 'NORMAL';
        
        var DURUM = document.getElementById(ResimYon + ResimNo).checked
        document.getElementById(ResimYon + ResimNo).checked =  !DURUM;

        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            document.getElementById(ResimNo).className = ResimYon;
        }
    }

    function FormuPostala(FormAdi) {

        // AJAX ile FİLE UPLOAD

        var form = $('#' + FormAdi)[0]; // Burada standart javascript objesi kullanılması gerekiyor
        var data = new FormData(form);

        // İlave değişken eklemek istersek
        // data.append("OZEL1", "Deger1");
        // data.append("OZEL2", "Deger2");

        // Dosya Ekleme
        // data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url        : '1test.php',
            type       : 'POST',
            enctype    : 'multipart/form-data',
            data       : data,
            cache      : false,
            timeout    : 600000,
            dataType   : "text",
            processData: false,
            contentType: false,
            success  : function(ajaxCevap)
            { 
               alert(ajaxCevap); // Cevabı göster...
            }
        } );

    } // FormuPostala

</script>
