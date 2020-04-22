<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <link rel="stylesheet" href="simpleLightbox/simpleLightbox.css" />

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
    <form id="formBirlestir" name="formBirlestir" method="post" action="" enctype="multipart/form-data" style="display:none1">
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
                    <td nowrap="nowrap"> Dosyalar arasına 1 boş sayfa ekle </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarBirlestir2"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Dosyalar arasına 2 boş sayfa ekle </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarBirlestir3"> </td>
                </tr>
            </table>
        </fieldset>



        <input type="button" value="Birleştir" onclick="FormuPostala('formBirlestir')" id="FormuGonder">
    </form>



    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- =========================== SİL ========================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formSil" name="formSil" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formSil">

        <h2>PDF Dosyadan Sayfa Sil</h2>

        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya (Çoklu Seçim)</td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosyaSil[]' multiple> </td>
                </tr>
            </table>
        </fieldset>


        <fieldset>
            <legend><b style='color: darkred;'>PDF'den Sayfa Silme Seçenekleri:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Sadece şu sayfaları sil </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarSil1" style="width: 250px;" placeholder="Örnek: 1,7,10,50-60"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Sadece şu sayfaları bırak, diğerlerini sil </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarSil4" style="width: 250px;" placeholder="Örnek: 1,7,10,50-60"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> TEK sayfaların hepsini sil </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarSil2"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> ÇİFT sayfaların hepsini sil </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarSil3"> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Sayfaları Sil" onclick="FormuPostala('formSil')" id="FormuGonder">
    </form>




    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- =========================== BÖL ========================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formBol" name="formBol" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formBol">

        <h2>PDF Dosyayı Böl</h2>

        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosyaBol[]'> </td>
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
                    <td nowrap="nowrap"> Şu sayfalardan başlayıp böl ve ayrı PDF'ler yap (*)</td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarBol3" style="width: 250px;" placeholder="Örnek: 6,18,27,33"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Şu sayfaları alarak böl (Her ';' ayrımı, ayrı bir PDF olacak) </td>
                    <td nowrap="nowrap">
                        <input type="text" name="AyarBol4" style="width: 250px;" placeholder="Örnek: 1,7,10,50-60;18-30,35-40"> </td>
                </tr>
            </table>
        </fieldset>
        <p><b>*</b> Yeni dosya, bu sayfadan itibaren başlar</p>
        <input type="button" value="Böl" onclick="FormuPostala('formBol')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- =========================== RESİM ======================== -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formResim1" name="formResim1" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formResim1">

        <h2>PDF'den Resim'e</h2>

        <fieldset>
            <legend><b style='color: darkred;'>PDF'den Resim Üret:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya (Çoklu Seçim) </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='AnaDosyaResim1[]' multiple> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> PDF içindeki tüm resimleri çıkar </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResimPDFYap1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> PDF'in her sayfasını JPG dosyası olarak çıkar </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResimPDFYap2">
                        <select name="AyarResimPDFYap3" style='width:250px;margin-left: 20px;'>
                            <option value="70">JPG Dosyasının Kalitesi: 75</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                            <option value="70">70</option>
                            <option value="75">75</option>
                            <option value="80">80</option>
                            <option value="85">85</option>
                            <option value="90">90</option>
                        </select> </td>
                </tr>
            </table>
        </fieldset>
        <input type="button" value="Başla !" onclick="FormuPostala('formResim1')" id="FormuGonder">
    </form>



    <form id="formResim2" name="formResim2" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formResim2">

        <h2>Resim'den PDF'e</h2>

        <fieldset>
            <legend><b style='color: darkred;'>Resim'den PDF üret: (Sadece jpg ve png)</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Resim Dosyalarını Seçiniz (Çoklu Seçim)</td>
                    <td nowrap="nowrap">
                        <input accept='image/jpeg,image/png' type='file' name='AnaDosyaResim2[]' multiple> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Resimlerin her birini PDF dosya yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResim1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Resimlerden bir tane PDF dosya yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarResim2"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> A4 Kağıt Yönü </td>
                    <td nowrap="nowrap">
                        <select name="AyarResim3" style='width:300px;'>
                            <option value="P">Kağıt Yönü: A4, Dikey (Portrait)</option>
                            <option value="L">Kağıt Yönü: A4, Yatay (Landscape)</option>
                        </select> </td>
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
    <form id="formHarmanla" name="formHarmanla" method="post" action="" enctype="multipart/form-data" style="display:none1">
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
                        <input type='text' name='Harman_Adet[]' value='1' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_Baslama[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
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
                        <input type='text' name='Harman_Adet[]' value='1' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_Baslama[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
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
                        <input type='text' name='Harman_Adet[]' value='1' placeholder='Örnek: 4' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='Harman_Baslama[]' value='1' placeholder='Örnek: 1' style='width: 250px;'>
                    </td>
                </tr>

            </table>
        </fieldset>
        <p><b>NOT: </b>Harmanlanacak dosyaların herhangi biri biterse işlem sonlandırılır.<br></p>


        <fieldset>
            <legend><b style='color: darkred;'>Harmanlama Seçenekleri:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Her hamanlama turu ayrı bir PDF olsun </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarHarman1"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Tümünü tek dosyaya harmanla </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="AyarHarman2"> </td>
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
    <form id="formArayaEkle" name="formArayaEkle" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formArayaEkle">

        <h2>PDF Dosyanın Arasına PDF Ekle</h2>

        <fieldset>
            <legend><b style='color: darkred;'>Ana PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='ArayaEkleANA[]' multiple> </td>
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
                        <input accept='application/pdf' type='file' name='ArayaEklePDF[]'>
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
                        <input accept='application/pdf' type='file' name='ArayaEklePDF[]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[]' style='width: 250px;' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)'>
                    </td>
                </tr>

            </table>
        </fieldset>
        <p><b>NOT: </b>Dosyaya eklemeler sıralı olmalıdır.</p>
        <input type="button" value="Araya Ekle" onclick="FormuPostala('formArayaEkle')" id="FormuGonder">
    </form>


    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <!-- ========================== YONET ========================= -->
    <!-- ========================================================== -->
    <!-- ========================================================== -->
    <form id="formYonet1" name="formYonet1" method="post" action="" enctype="multipart/form-data" style="display:none1">
        <input type="hidden" name="FormAdi" value="formYonet1">

        <h2>Sayfaları Düzenle</h2>

        <fieldset>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input accept='application/pdf' type='file' name='YonetAnaPDF[]'> </td>
                    <td nowrap="nowrap">
                        <input type="button" value="Başla !" onclick="GelismisYonetimHazirlikFormuPostala('formYonet1')" id="FormuGonder"> </td>
                </tr>
            </table>
        </fieldset>
    </form>


    <form id="formYonet2" name="formYonet2" method="post" action="" enctype="multipart/form-data" style="display:none">


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

        <p> <b>NOT 1:</b> Boş sayfa ekleme ve Sayfa Silme aynı anda kullanılacak olursa, boş sayfa eklenir ancak sayfa silme yapılmaz.
        <br><b>NOT 2:</b> Boş sayfa ekleme, ekrandaki  <b>Sayfa:</b> yazan alana bakılarak yapılır</p>


        <input type="hidden" name="FormAdi" value="formYonet2">

        <h2>Sayfa Yönü Değiştir / Sırala</h2>

        <p>Sürükle bırakarak yaparak sayfaların yerlerini değiştirebilirsiniz.<br>Yeşil oklara tıklayarak sayfa yönünü değiştirebilirsiniz.</p>

        <fieldset>
            <legend><b style='color: darkred;'>SAYFALARI DÜZENLE</b></legend>

            <ul class="PDFSayfalari" id="YONETIM_ALANI">
<!--
                <li>
                    <div class='frameImg'>
                        <img id='0' src='pul/Sayfa-000.jpg'>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='0'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL0' name='sol[0]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG0' name='sag[0]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK0' name='dik[0]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL0' name='sil[0]'>
                        <div class='LabelYON' onclick="Cevir1(0, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(0, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(0, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(0, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: TEST</span>
                    </div>
                </li>
-->


<!--
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-1.jpg?433090077' XXonclick='return false;'><img id='1' src='upload/Sayfa-1.jpg?433090077'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='1'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL1' name='sol[1]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG1' name='sag[1]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK1' name='dik[1]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL1' name='sil[1]'>
                        <div class='LabelYON' onclick="Cevir1(1, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(1, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(1, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(1, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 1</span>
                    </div>
                </li>
                 
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-2.jpg?1296285728' XXonclick='return false;'><img id='2' src='upload/Sayfa-2.jpg?1296285728'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='2'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL2' name='sol[2]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG2' name='sag[2]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK2' name='dik[2]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL2' name='sil[2]'>
                        <div class='LabelYON' onclick="Cevir1(2, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(2, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(2, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(2, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 2</span>
                    </div>
                </li>
                 
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-3.jpg?1841219098' XXonclick='return false;'><img id='3' src='upload/Sayfa-3.jpg?1841219098'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='3'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL3' name='sol[3]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG3' name='sag[3]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK3' name='dik[3]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL3' name='sil[3]'>
                        <div class='LabelYON' onclick="Cevir1(3, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(3, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(3, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(3, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 3</span>
                    </div>
                </li>
                 
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-4.jpg?943278569' XXonclick='return false;'><img id='4' src='upload/Sayfa-4.jpg?943278569'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='4'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL4' name='sol[4]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG4' name='sag[4]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK4' name='dik[4]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL4' name='sil[4]'>
                        <div class='LabelYON' onclick="Cevir1(4, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(4, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(4, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(4, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 4</span>
                    </div>
                </li>
                 
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-5.jpg?2026638275' XXonclick='return false;'><img id='5' src='upload/Sayfa-5.jpg?2026638275'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='5'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL5' name='sol[5]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG5' name='sag[5]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK5' name='dik[5]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL5' name='sil[5]'>
                        <div class='LabelYON' onclick="Cevir1(5, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(5, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(5, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(5, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 5</span>
                    </div>
                </li>
                 
                <li>
                    <div class='frameImg'>
                        <a href='upload/Sayfa-6.jpg?1374216907' XXonclick='return false;'><img id='6' src='upload/Sayfa-6.jpg?1374216907'></a>
                    </div>
                    <div class='frameButtons'>
                        <input type='hidden' name='sayfa_no[]' value='6'>
                        <input type='checkbox' class='chkBoxGizli' id='SOL6' name='sol[6]'>
                        <input type='checkbox' class='chkBoxGizli' id='SAG6' name='sag[6]'>
                        <input type='checkbox' class='chkBoxGizli' id='DIK6' name='dik[6]'>
                        <input type='checkbox' class='chkBoxGizli' id='SIL6' name='sil[6]'>
                        <div class='LabelYON' onclick="Cevir1(6, 'SOL')"> &#8630; </div>
                        <div class='LabelYON' onclick="Cevir1(6, 'SAG')"> &#8631; </div>
                        <div class='LabelYON' onclick="Cevir1(6, 'DIK')"> &#8645; </div>
                        <div class='LabelYON' onclick="SayfaSil(6, 'SIL')"> &#9851; </div>
                        <span class='SayfaNo'>Sayfa: 6</span>
                    </div>
                </li>
                 
-->


            </ul> <!-- /PDFSayfalari -->

            <div style="clear:both;height:1px;"></div>
        </fieldset>

        <input type="button" value="Değişiklikleri Kaydet" onclick="FormuPostala('formYonet2')" id="FormuGonder">
    </form>

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

    #formBirlestir  {border-left: 15px solid #E64A19; padding-left: 20px; }
    #formSil        {border-left: 15px solid #FF5722; padding-left: 20px; }
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
        border: 0px solid darkgrey;
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

    .SayfaSil {
        background-color: #f44336 !important;
    }

    .frameImg {
        overflow: hidden;
        margin: 3px;
    }
    .frameButtons {
        overflow: hidden;
        height: 60px !important;
        width: 100% !important;
        border: 0px solid black;
        margin-top: 5px;
    }
    .PDFSayfalari img {
        margin: 5px;
        border: 0px solid lightgray;
        object-fit: scale-down;
        height: 150px !important;
        width: 95% !important;
    }

    .LabelYON {
        font-size: 25px;
        margin-left: 0px !important;
        background-color: #A5D6A7 !important;
        margin: 0px;
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


    #FormuGonder:hover {
        background-color: #C51162;
    }


</style>




<script src="js/jquery-3.4.1.min.js"></script>
<script src="simpleLightbox/simpleLightbox.js"></script>
<!-- KAYNAK: https://dbrekalo.github.io/simpleLightbox/  -->
<script src="dropMe/dropMe.js"></script>
<!-- KAYNAK: http://naukri-engineering.github.io/dropMe/  -->

<script>

    function SayfalariSurukleBirakIcinHazirla() {
        $('.PDFSayfalari').dropme('destroy');
        $('.PDFSayfalari').dropme({
            // items: '.PDFSayfa'
        });
    }


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

    function FileUploadWithAjax() {

        // AJAX ile FİLE UPLOAD

        var form = $('#form1')[0]; // You need to use standard javascript object here
        var data = new FormData(form);
        data.append("CustomField1", "This is some extra data, testing");
        data.append("CustomField2", "This is some extra data, testing");
        // Attach file
        data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url    : 'islemyap.php',
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


    function Cevir1(ResimNo, ResimYon) {
        document.getElementById(ResimNo).className = 'NORMAL';

        var DURUM = document.getElementById(ResimYon + ResimNo).checked
        document.getElementById(ResimYon + ResimNo).checked =  !DURUM;

        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            document.getElementById(ResimNo).className = ResimYon;
        }
    }


    function SayfaSil(ResimNo, ResimYon) {

        var DURUM = document.getElementById(ResimYon + ResimNo).checked
        document.getElementById(ResimYon + ResimNo).checked =  !DURUM;

        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            $("#"+ResimNo).parent().parent().addClass('SayfaSil');
        } else {
            $("#"+ResimNo).parent().parent().removeClass('SayfaSil');
        }

    }

    function GelismisYonetimHazirlikFormuPostala(FormAdi) {

        var HATAVAR = 0
        HATAVAR = DosyaSecilmemis(FormAdi);
        if( HATAVAR == 1 ) {
            alert("Dosya seçimi yapılmamış!")
            return;
        }
        // AJAX ile FİLE UPLOAD

        var form = $('#' + FormAdi)[0]; // Burada standart javascript objesi kullanılması gerekiyor
        var data = new FormData(form);

        // İlave değişken eklemek istersek
        // data.append("OZEL1", "Deger1");
        // data.append("OZEL2", "Deger2");

        // Dosya Ekleme
        // data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url        : 'islemyap.php',
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
                $("#formYonet2").show();
                $("#YONETIM_ALANI").html(ajaxCevap); // Cevabı ekrana yaz

                new SimpleLightbox({elements: '.frameImg a'});
                SayfalariSurukleBirakIcinHazirla();
            }
        } );

    } // GelismisYonetimHazirlikFormuPostala

    jQuery(document).ready(function($) {
        // new SimpleLightbox({elements: '.frameImg a'});
        // SayfalariSurukleBirakIcinHazirla();
    });

    function FormuPostala(FormAdi) {

        if(FormAdi != 'formYonet2') {
            var HATAVAR = 0
            HATAVAR = DosyaSecilmemis(FormAdi);
            if( HATAVAR == 1 ) {
                alert("Dosya seçimi yapılmamış!")
                return;
            }
        }
        // AJAX ile FİLE UPLOAD

        var form = $('#' + FormAdi)[0]; // Burada standart javascript objesi kullanılması gerekiyor
        var data = new FormData(form);

        // İlave değişken eklemek istersek
        // data.append("OZEL1", "Deger1");
        // data.append("OZEL2", "Deger2");

        // Dosya Ekleme
        // data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url        : 'islemyap.php',
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



    // Dosya Yükleme bölümünde seçim yapılıp yapılmadığı kontrolü
    // Dosya Yükleme bölümünde seçim yapılıp yapılmadığı kontrolü
    var DosyalarTekli    = 0;
    var DosyalarCoklu    = 0;
    var AnaDosyaSil      = 0;
    var AnaDosyaBol      = 0;
    var AnaDosyaResim1   = 0;
    var AnaDosyaResim2   = 0;
    var HarmanPDF        = 0;
    var ArayaEkleANA     = 0;
    var ArayaEklePDF     = 0;
    var YonetAnaPDF      = 0;

    jQuery(document).ready(function($) {

        $(document).on('change', 'input:file', function() {
            if( this.name == "DosyalarTekli[]"  ) DosyalarTekli    = 1;
            if( this.name == "DosyalarCoklu[]"  ) DosyalarCoklu    = 1;
            if( this.name == "AnaDosyaSil[]"    ) AnaDosyaSil      = 1;
            if( this.name == "AnaDosyaBol[]"    ) AnaDosyaBol      = 1;
            if( this.name == "AnaDosyaResim1[]" ) AnaDosyaResim1   = 1;
            if( this.name == "AnaDosyaResim2[]" ) AnaDosyaResim2   = 1;
            if( this.name == "HarmanPDF[]"      ) HarmanPDF        = 1;
            if( this.name == "ArayaEkleANA[]"   ) ArayaEkleANA     = 1;
            if( this.name == "ArayaEklePDF[]"   ) ArayaEklePDF     = 1;
            if( this.name == "YonetAnaPDF[]"    ) YonetAnaPDF      = 1;
        });

    });


    function DosyaSecilmemis(FormAdi){

        if( FormAdi == "formBirlestir" ) return ( DosyalarTekli  == 0 && DosyalarCoklu == 0 );
        if( FormAdi == "formSil"       ) return ( AnaDosyaSil    == 0 );
        if( FormAdi == "formBol"       ) return ( AnaDosyaBol    == 0 );
        if( FormAdi == "formResim1"    ) return ( AnaDosyaResim1 == 0 );
        if( FormAdi == "formResim2"    ) return ( AnaDosyaResim2 == 0 );
        if( FormAdi == "formHarmanla"  ) return ( HarmanPDF      == 0 );
        if( FormAdi == "formArayaEkle" ) return ( ArayaEkleANA   == 0 || ArayaEklePDF  == 0 );
        if( FormAdi == "formYonet1"    ) return ( YonetAnaPDF    == 0 );

        alert(FormAdi + " İçin Buraya gelmemeliydi!")
        return true; //true: Dosya seçimi yapılmamış

    } // DosyaSecilmemis



</script>
