<?php 

if(!function_exists('old_value')) {
    function old_value($field,$object) {
        return  old($field) ? old($field) : $object->$field;
    }
}

if(!function_exists('arabic_country_array')) {
    function arabic_country_array(): Array{
        return array(
            "AW" => "آروبا",
            "AZ" => "أذربيجان",
            "AM" => "أرمينيا",
            "ES" => "أسبانيا",
            "AU" => "أستراليا",
            "AF" => "أفغانستان",
            "AL" => "ألبانيا",
            "DE" => "ألمانيا",
            "AG" => "أنتيجوا وبربودا",
            "AO" => "أنجولا",
            "AI" => "أنجويلا",
            "AD" => "أندورا",
            "UY" => "أورجواي",
            "UZ" => "أوزبكستان",
            "UG" => "أوغندا",
            "UA" => "أوكرانيا",
            "IE" => "أيرلندا",
            "IS" => "أيسلندا",
            "ET" => "اثيوبيا",
            "ER" => "اريتريا",
            "EE" => "استونيا",
            "IL" => "اسرائيل",
            "AR" => "الأرجنتين",
            "JO" => "الأردن",
            "EC" => "الاكوادور",
            "AE" => "الامارات العربية المتحدة",
            "BS" => "الباهاما",
            "BH" => "البحرين",
            "BR" => "البرازيل",
            "PT" => "البرتغال",
            "BA" => "البوسنة والهرسك",
            "GA" => "الجابون",
            "ME" => "الجبل الأسود",
            "DZ" => "الجزائر",
            "DK" => "الدانمرك",
            "CV" => "الرأس الأخضر",
            "SV" => "السلفادور",
            "SN" => "السنغال",
            "SD" => "السودان",
            "SE" => "السويد",
            "EH" => "الصحراء الغربية",
            "SO" => "الصومال",
            "CN" => "الصين",
            "IQ" => "العراق",
            "VA" => "الفاتيكان",
            "PH" => "الفيلبين",
            "AQ" => "القطب الجنوبي",
            "CM" => "الكاميرون",
            "CG" => "الكونغو - برازافيل",
            "KW" => "الكويت",
            "HU" => "المجر",
            "IO" => "المحيط الهندي البريطاني",
            "MA" => "المغرب",
            "TF" => "المقاطعات الجنوبية الفرنسية",
            "MX" => "المكسيك",
            "SA" => "المملكة العربية السعودية",
            "GB" => "المملكة المتحدة",
            "NO" => "النرويج",
            "AT" => "النمسا",
            "NE" => "النيجر",
            "IN" => "الهند",
            "US" => "الولايات المتحدة الأمريكية",
            "JP" => "اليابان",
            "YE" => "اليمن",
            "GR" => "اليونان",
            "ID" => "اندونيسيا",
            "IR" => "ايران",
            "IT" => "ايطاليا",
            "PG" => "بابوا غينيا الجديدة",
            "PY" => "باراجواي",
            "PK" => "باكستان",
            "PW" => "بالاو",
            "BW" => "بتسوانا",
            "PN" => "بتكايرن",
            "BB" => "بربادوس",
            "BM" => "برمودا",
            "BN" => "بروناي",
            "BE" => "بلجيكا",
            "BG" => "بلغاريا",
            "BZ" => "بليز",
            "BD" => "بنجلاديش",
            "PA" => "بنما",
            "BJ" => "بنين",
            "BT" => "بوتان",
            "PR" => "بورتوريكو",
            "BF" => "بوركينا فاسو",
            "BI" => "بوروندي",
            "PL" => "بولندا",
            "BO" => "بوليفيا",
            "PF" => "بولينيزيا الفرنسية",
            "PE" => "بيرو",
            "TZ" => "تانزانيا",
            "TH" => "تايلند",
            "TW" => "تايوان",
            "TM" => "تركمانستان",
            "TR" => "تركيا",
            "TT" => "ترينيداد وتوباغو",
            "TD" => "تشاد",
            "TG" => "توجو",
            "TV" => "توفالو",
            "TK" => "توكيلو",
            "TO" => "تونجا",
            "TN" => "تونس",
            "TL" => "تيمور الشرقية",
            "JM" => "جامايكا",
            "GI" => "جبل طارق",
            "GD" => "جرينادا",
            "GL" => "جرينلاند",
            "AX" => "جزر أولان",
            "AN" => "جزر الأنتيل الهولندية",
            "TC" => "جزر الترك وجايكوس",
            "KM" => "جزر القمر",
            "KY" => "جزر الكايمن",
            "MH" => "جزر المارشال",
            "MV" => "جزر الملديف",
            "UM" => "جزر الولايات المتحدة البعيدة الصغيرة",
            "SB" => "جزر سليمان",
            "FO" => "جزر فارو",
            "VI" => "جزر فرجين الأمريكية",
            "VG" => "جزر فرجين البريطانية",
            "FK" => "جزر فوكلاند",
            "CK" => "جزر كوك",
            "CC" => "جزر كوكوس",
            "MP" => "جزر ماريانا الشمالية",
            "WF" => "جزر والس وفوتونا",
            "CX" => "جزيرة الكريسماس",
            "BV" => "جزيرة بوفيه",
            "IM" => "جزيرة مان",
            "NF" => "جزيرة نورفوك",
            "HM" => "جزيرة هيرد وماكدونالد",
            "CF" => "جمهورية افريقيا الوسطى",
            "CZ" => "جمهورية التشيك",
            "DO" => "جمهورية الدومينيك",
            "CD" => "جمهورية الكونغو الديمقراطية",
            "ZA" => "جمهورية جنوب افريقيا",
            "GT" => "جواتيمالا",
            "GP" => "جوادلوب",
            "GU" => "جوام",
            "GE" => "جورجيا",
            "GS" => "جورجيا الجنوبية وجزر ساندويتش الجنوبية",
            "DJ" => "جيبوتي",
            "JE" => "جيرسي",
            "DM" => "دومينيكا",
            "RW" => "رواندا",
            "RU" => "روسيا",
            "BY" => "روسيا البيضاء",
            "RO" => "رومانيا",
            "RE" => "روينيون",
            "ZM" => "زامبيا",
            "ZW" => "زيمبابوي",
            "CI" => "ساحل العاج",
            "WS" => "ساموا",
            "AS" => "ساموا الأمريكية",
            "SM" => "سان مارينو",
            "PM" => "سانت بيير وميكولون",
            "VC" => "سانت فنسنت وغرنادين",
            "KN" => "سانت كيتس ونيفيس",
            "LC" => "سانت لوسيا",
            "MF" => "سانت مارتين",
            "SH" => "سانت هيلنا",
            "ST" => "ساو تومي وبرينسيبي",
            "LK" => "سريلانكا",
            "SJ" => "سفالبارد وجان مايان",
            "SK" => "سلوفاكيا",
            "SI" => "سلوفينيا",
            "SG" => "سنغافورة",
            "SZ" => "سوازيلاند",
            "SY" => "سوريا",
            "SR" => "سورينام",
            "CH" => "سويسرا",
            "SL" => "سيراليون",
            "SC" => "سيشل",
            "CL" => "شيلي",
            "RS" => "صربيا",
            "CS" => "صربيا والجبل الأسود",
            "TJ" => "طاجكستان",
            "OM" => "عمان",
            "GM" => "غامبيا",
            "GH" => "غانا",
            "GF" => "غويانا",
            "GY" => "غيانا",
            "GN" => "غينيا",
            "GQ" => "غينيا الاستوائية",
            "GW" => "غينيا بيساو",
            "VU" => "فانواتو",
            "FR" => "فرنسا",
            "PS" => "فلسطين",
            "VE" => "فنزويلا",
            "FI" => "فنلندا",
            "VN" => "فيتنام",
            "FJ" => "فيجي",
            "CY" => "قبرص",
            "KG" => "قرغيزستان",
            "QA" => "قطر",
            "KZ" => "كازاخستان",
            "NC" => "كاليدونيا الجديدة",
            "HR" => "كرواتيا",
            "KH" => "كمبوديا",
            "CA" => "كندا",
            "CU" => "كوبا",
            "KR" => "كوريا الجنوبية",
            "KP" => "كوريا الشمالية",
            "CR" => "كوستاريكا",
            "CO" => "كولومبيا",
            "KI" => "كيريباتي",
            "KE" => "كينيا",
            "LV" => "لاتفيا",
            "LA" => "لاوس",
            "LB" => "لبنان",
            "LU" => "لوكسمبورج",
            "LY" => "ليبيا",
            "LR" => "ليبيريا",
            "LT" => "ليتوانيا",
            "LI" => "ليختنشتاين",
            "LS" => "ليسوتو",
            "MQ" => "مارتينيك",
            "MO" => "ماكاو الصينية",
            "MT" => "مالطا",
            "ML" => "مالي",
            "MY" => "ماليزيا",
            "YT" => "مايوت",
            "MG" => "مدغشقر",
            "EG" => "مصر",
            "MK" => "مقدونيا",
            "MW" => "ملاوي",
            "ZZ" => "منطقة غير معرفة",
            "MN" => "منغوليا",
            "MR" => "موريتانيا",
            "MU" => "موريشيوس",
            "MZ" => "موزمبيق",
            "MD" => "مولدافيا",
            "MC" => "موناكو",
            "MS" => "مونتسرات",
            "MM" => "ميانمار",
            "FM" => "ميكرونيزيا",
            "NA" => "ناميبيا",
            "NR" => "نورو",
            "NP" => "نيبال",
            "NG" => "نيجيريا",
            "NI" => "نيكاراجوا",
            "NZ" => "نيوزيلاندا",
            "NU" => "نيوي",
            "HT" => "هايتي",
            "HN" => "هندوراس",
            "NL" => "هولندا",
            "HK" => "هونج كونج الصينية",
            );            
    }


    if(!function_exists('get_status')){
        function get_status(){
            return ['paid','failed','processing','cancelled','done','received','pending'];
        }

    }
}

