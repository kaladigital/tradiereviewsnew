(function ($) {
   $(function () {
      $(".phone-number-group").each(function () {
         var input = $(this).find("input");
         $(input).focus(function () {
            $(input).parents(".phone-number-group").addClass("focused");
            // if ($(this).val().length === 0) {
            // }
         }).blur(function () {
            $(input).parents(".phone-number-group").removeClass("focused");
            if ($(input).val().length === 0) {
               $(input).parents(".phone-number-group").removeClass('value-added');
            } else if ($(input).val().length > 0) {
               $(input).parents(".phone-number-group").addClass('value-added');
            }
         });
         // Ends input common focus and blur for value.
      })

      setTimeout(function () {
         if ($('.TradieFlow-select-dropdown').length) {
            $('.TradieFlow-select-dropdown').select2();
         }
         if ($('.selectView').length) {
            $('.selectView').select2();
         }
      }, 800)

      if ($('#selectNewStartTime').length) {
         $('#selectNewStartTime').datetimepicker();
      }
      if ($('#selectNewEndTime').length) {
         $('#selectNewEndTime').datetimepicker();
      }

      if ($("[name='selectStartTime']").length) {
         $("[name='selectStartTime']").datetimepicker();
      }
      if ($("[name='selectEndTime']").length) {
         $("[name='selectEndTime']").datetimepicker();
      }

      // Audio player
      if ($(".audio-player").length) {
         $(".audio-player").each(function () {
            var _this = $(this);
            var wavesurfer = WaveSurfer.create({
               container: document.querySelector('#waveform'),
               waveColor: 'rgba(67, 209, 79, 0.3)',
               progressColor: '#43d14f',
               cursorColor: '#4353FF',
               barWidth: 2,
               barRadius: 2,
               cursorWidth: 1,
               height: 30,
               barGap: 3
            });
            wavesurfer.load('../audio/example-audio.wav');

            _this.find(".play-btn").on("click", function () {
               wavesurfer.play();
               $(this).hide();
               _this.find(".pause-btn").show();
               $(this).parent().addClass("playing");
            })
            _this.find(".pause-btn").on("click", function () {
               wavesurfer.pause();
               $(this).hide();
               _this.find(".play-btn").show();
               $(this).parent().addClass("paused");
            })
            _this.find(".stop-btn").on("click", function () {
               wavesurfer.stop();
               _this.find(".pause-btn").hide();
               _this.find(".play-btn").show();
               $(this).parent().removeClass("playing paused");
            })
            wavesurfer.on('finish', function () {
               _this.find(".audio-player").find(".controls").removeClass("playing paused");
               _this.find(".pause-btn").hide();
               _this.find(".play-btn").show();
            });
         })
      }

   }) // End ready function

   // Window load function
   $(window).on("load", function () {
      // Add country with flag in select2 plugin
      var isoCountries = [
         {
            text: "Afghanistan",
            dialCode: "+93",
            id: "AF",
            flag: "https://www.countryflags.io/AF/flat/32.png"
         },
         {
            text: "Aland Islands",
            dialCode: "+358",
            id: "AX",
            flag: "https://www.countryflags.io/AX/flat/32.png"
         },
         {
            text: "Albania",
            dialCode: "+355",
            id: "AL",
            flag: "https://www.countryflags.io/AL/flat/32.png"
         },
         {
            text: "Algeria",
            dialCode: "+213",
            id: "DZ",
            flag: "https://www.countryflags.io/DZ/flat/32.png"
         },
         {
            text: "AmericanSamoa",
            dialCode: "+1684",
            id: "AS",
            flag: "https://www.countryflags.io/AS/flat/32.png"
         },
         {
            text: "Andorra",
            dialCode: "+376",
            id: "AD",
            flag: "https://www.countryflags.io/AD/flat/32.png"
         },
         {
            text: "Angola",
            dialCode: "+244",
            id: "AO",
            flag: "https://www.countryflags.io/AO/flat/32.png"
         },
         {
            text: "Anguilla",
            dialCode: "+1264",
            id: "AI",
            flag: "https://www.countryflags.io/AI/flat/32.png"
         },
         {
            text: "Antarctica",
            dialCode: "+672",
            id: "AQ",
            flag: "https://www.countryflags.io/AQ/flat/32.png"
         },
         {
            text: "Antigua and Barbuda",
            dialCode: "+1268",
            id: "AG",
            flag: "https://www.countryflags.io/AG/flat/32.png"
         },
         {
            text: "Argentina",
            dialCode: "+54",
            id: "AR",
            flag: "https://www.countryflags.io/AR/flat/32.png"
         },
         {
            text: "Armenia",
            dialCode: "+374",
            id: "AM",
            flag: "https://www.countryflags.io/AM/flat/32.png"
         },
         {
            text: "Aruba",
            dialCode: "+297",
            id: "AW",
            flag: "https://www.countryflags.io/AW/flat/32.png"
         },
         {
            text: "Ascension Island",
            dialCode: "+247",
            id: "AC",
            flag: "http://www.flaginstitute.org/wp/wp-content/uploads/flags/lowres_Ascension.png"
         },
         {
            text: "Australia",
            dialCode: "+61",
            id: "AU",
            flag: "https://www.countryflags.io/AU/flat/32.png"
         },
         {
            text: "Austria",
            dialCode: "+43",
            id: "AT",
            flag: "https://www.countryflags.io/AT/flat/32.png"
         },
         {
            text: "Azerbaijan",
            dialCode: "+994",
            id: "AZ",
            flag: "https://www.countryflags.io/AZ/flat/32.png"
         },
         {
            text: "Bahamas",
            dialCode: "+1242",
            id: "BS",
            flag: "https://www.countryflags.io/BS/flat/32.png"
         },
         {
            text: "Bahrain",
            dialCode: "+973",
            id: "BH",
            flag: "https://www.countryflags.io/BH/flat/32.png"
         },
         {
            text: "Bangladesh",
            dialCode: "+880",
            id: "BD",
            flag: "https://www.countryflags.io/BD/flat/32.png"
         },
         {
            text: "Barbados",
            dialCode: "+1246",
            id: "BB",
            flag: "https://www.countryflags.io/BB/flat/32.png"
         },
         {
            text: "Belarus",
            dialCode: "+375",
            id: "BY",
            flag: "https://www.countryflags.io/BY/flat/32.png"
         },
         {
            text: "Belgium",
            dialCode: "+32",
            id: "BE",
            flag: "https://www.countryflags.io/BE/flat/32.png"
         },
         {
            text: "Belize",
            dialCode: "+501",
            id: "BZ",
            flag: "https://www.countryflags.io/BZ/flat/32.png"
         },
         {
            text: "Benin",
            dialCode: "+229",
            id: "BJ",
            flag: "https://www.countryflags.io/BJ/flat/32.png"
         },
         {
            text: "Bermuda",
            dialCode: "+1441",
            id: "BM",
            flag: "https://www.countryflags.io/BM/flat/32.png"
         },
         {
            text: "Bhutan",
            dialCode: "+975",
            id: "BT",
            flag: "https://www.countryflags.io/BT/flat/32.png"
         },
         {
            text: "Bolivia",
            dialCode: "+591",
            id: "BO",
            flag: "https://www.countryflags.io/BO/flat/32.png"
         },
         {
            text: "Bosnia and Herzegovina",
            dialCode: "+387",
            id: "BA",
            flag: "https://www.countryflags.io/BA/flat/32.png"
         },
         {
            text: "Botswana",
            dialCode: "+267",
            id: "BW",
            flag: "https://www.countryflags.io/BW/flat/32.png"
         },
         {
            text: "Brazil",
            dialCode: "+55",
            id: "BR",
            flag: "https://www.countryflags.io/BR/flat/32.png"
         },
         {
            text: "British Indian Ocean Territory",
            dialCode: "+246",
            id: "IO",
            flag: "https://www.countryflags.io/IO/flat/32.png"
         },
         {
            text: "Brunei Darussalam",
            dialCode: "+673",
            id: "BN",
            flag: "https://www.countryflags.io/BN/flat/32.png"
         },
         {
            text: "Bulgaria",
            dialCode: "+359",
            id: "BG",
            flag: "https://www.countryflags.io/BG/flat/32.png"
         },
         {
            text: "Burkina Faso",
            dialCode: "+226",
            id: "BF",
            flag: "https://www.countryflags.io/BF/flat/32.png"
         },
         {
            text: "Burundi",
            dialCode: "+257",
            id: "BI",
            flag: "https://www.countryflags.io/BI/flat/32.png"
         },
         {
            text: "Cambodia",
            dialCode: "+855",
            id: "KH",
            flag: "https://www.countryflags.io/KH/flat/32.png"
         },
         {
            text: "Cameroon",
            dialCode: "+237",
            id: "CM",
            flag: "https://www.countryflags.io/CM/flat/32.png"
         },
         {
            text: "Canada",
            dialCode: "+1",
            id: "CA",
            flag: "https://www.countryflags.io/CA/flat/32.png"
         },
         {
            text: "Cape Verde",
            dialCode: "+238",
            id: "CV",
            flag: "https://www.countryflags.io/CV/flat/32.png"
         },
         {
            text: "Cayman Islands",
            dialCode: "+1345",
            id: "KY",
            flag: "https://www.countryflags.io/KY/flat/32.png"
         },
         {
            text: "Central African Republic",
            dialCode: "+236",
            id: "CF",
            flag: "https://www.countryflags.io/CF/flat/32.png"
         },
         {
            text: "Chad",
            dialCode: "+235",
            id: "TD",
            flag: "https://www.countryflags.io/TD/flat/32.png"
         },
         {
            text: "Chile",
            dialCode: "+56",
            id: "CL",
            flag: "https://www.countryflags.io/CL/flat/32.png"
         },
         {
            text: "China",
            dialCode: "+86",
            id: "CN",
            flag: "https://www.countryflags.io/CN/flat/32.png"
         },
         {
            text: "Christmas Island",
            dialCode: "+61",
            id: "CX",
            flag: "https://www.countryflags.io/CX/flat/32.png"
         },
         {
            text: "Cocos (Keeling) Islands",
            dialCode: "+61",
            id: "CC",
            flag: "https://www.countryflags.io/CC/flat/32.png"
         },
         {
            text: "Colombia",
            dialCode: "+57",
            id: "CO",
            flag: "https://www.countryflags.io/CO/flat/32.png"
         },
         {
            text: "Comoros",
            dialCode: "+269",
            id: "KM",
            flag: "https://www.countryflags.io/KM/flat/32.png"
         },
         {
            text: "Congo",
            dialCode: "+242",
            id: "CG",
            flag: "https://www.countryflags.io/CG/flat/32.png"
         },
         {
            text: "Cook Islands",
            dialCode: "+682",
            id: "CK",
            flag: "https://www.countryflags.io/CK/flat/32.png"
         },
         {
            text: "Costa Rica",
            dialCode: "+506",
            id: "CR",
            flag: "https://www.countryflags.io/CR/flat/32.png"
         },
         {
            text: "Croatia",
            dialCode: "+385",
            id: "HR",
            flag: "https://www.countryflags.io/HR/flat/32.png"
         },
         {
            text: "Cuba",
            dialCode: "+53",
            id: "CU",
            flag: "https://www.countryflags.io/CU/flat/32.png"
         },
         {
            text: "Cyprus",
            dialCode: "+357",
            id: "CY",
            flag: "https://www.countryflags.io/CY/flat/32.png"
         },
         {
            text: "Czech Republic",
            dialCode: "+420",
            id: "CZ",
            flag: "https://www.countryflags.io/CZ/flat/32.png"
         },
         {
            text: "Democratic Republic of the Congo",
            dialCode: "+243",
            id: "CD",
            flag: "https://www.countryflags.io/CD/flat/32.png"
         },
         {
            text: "Denmark",
            dialCode: "+45",
            id: "DK",
            flag: "https://www.countryflags.io/DK/flat/32.png"
         },
         {
            text: "Djibouti",
            dialCode: "+253",
            id: "DJ",
            flag: "https://www.countryflags.io/DJ/flat/32.png"
         },
         {
            text: "Dominica",
            dialCode: "+1767",
            id: "DM",
            flag: "https://www.countryflags.io/DM/flat/32.png"
         },
         {
            text: "Dominican Republic",
            dialCode: "+1849",
            id: "DO",
            flag: "https://www.countryflags.io/DO/flat/32.png"
         },
         {
            text: "Ecuador",
            dialCode: "+593",
            id: "EC",
            flag: "https://www.countryflags.io/EC/flat/32.png"
         },
         {
            text: "Egypt",
            dialCode: "+20",
            id: "EG",
            flag: "https://www.countryflags.io/EG/flat/32.png"
         },
         {
            text: "El Salvador",
            dialCode: "+503",
            id: "SV",
            flag: "https://www.countryflags.io/SV/flat/32.png"
         },
         {
            text: "Equatorial Guinea",
            dialCode: "+240",
            id: "GQ",
            flag: "https://www.countryflags.io/GQ/flat/32.png"
         },
         {
            text: "Eritrea",
            dialCode: "+291",
            id: "ER",
            flag: "https://www.countryflags.io/ER/flat/32.png"
         },
         {
            text: "Estonia",
            dialCode: "+372",
            id: "EE",
            flag: "https://www.countryflags.io/EE/flat/32.png"
         },
         {
            text: "Eswatini",
            dialCode: "+268",
            id: "SZ",
            flag: "https://www.countryflags.io/SZ/flat/32.png"
         },
         {
            text: "Ethiopia",
            dialCode: "+251",
            id: "ET",
            flag: "https://www.countryflags.io/ET/flat/32.png"
         },
         {
            text: "Falkland Islands (Malvinas)",
            dialCode: "+500",
            id: "FK",
            flag: "https://www.countryflags.io/FK/flat/32.png"
         },
         {
            text: "Faroe Islands",
            dialCode: "+298",
            id: "FO",
            flag: "https://www.countryflags.io/FO/flat/32.png"
         },
         {
            text: "Fiji",
            dialCode: "+679",
            id: "FJ",
            flag: "https://www.countryflags.io/FJ/flat/32.png"
         },
         {
            text: "Finland",
            dialCode: "+358",
            id: "FI",
            flag: "https://www.countryflags.io/FI/flat/32.png"
         },
         {
            text: "France",
            dialCode: "+33",
            id: "FR",
            flag: "https://www.countryflags.io/FR/flat/32.png"
         },
         {
            text: "French Guiana",
            dialCode: "+594",
            id: "GF",
            flag: "https://www.countryflags.io/GF/flat/32.png"
         },
         {
            text: "French Polynesia",
            dialCode: "+689",
            id: "PF",
            flag: "https://www.countryflags.io/PF/flat/32.png"
         },
         {
            text: "Gabon",
            dialCode: "+241",
            id: "GA",
            flag: "https://www.countryflags.io/GA/flat/32.png"
         },
         {
            text: "Gambia",
            dialCode: "+220",
            id: "GM",
            flag: "https://www.countryflags.io/GM/flat/32.png"
         },
         {
            text: "Georgia",
            dialCode: "+995",
            id: "GE",
            flag: "https://www.countryflags.io/GE/flat/32.png"
         },
         {
            text: "Germany",
            dialCode: "+49",
            id: "DE",
            flag: "https://www.countryflags.io/DE/flat/32.png"
         },
         {
            text: "Ghana",
            dialCode: "+233",
            id: "GH",
            flag: "https://www.countryflags.io/GH/flat/32.png"
         },
         {
            text: "Gibraltar",
            dialCode: "+350",
            id: "GI",
            flag: "https://www.countryflags.io/GI/flat/32.png"
         },
         {
            text: "Greece",
            dialCode: "+30",
            id: "GR",
            flag: "https://www.countryflags.io/GR/flat/32.png"
         },
         {
            text: "Greenland",
            dialCode: "+299",
            id: "GL",
            flag: "https://www.countryflags.io/GL/flat/32.png"
         },
         {
            text: "Grenada",
            dialCode: "+1473",
            id: "GD",
            flag: "https://www.countryflags.io/GD/flat/32.png"
         },
         {
            text: "Guadeloupe",
            dialCode: "+590",
            id: "GP",
            flag: "https://www.countryflags.io/GP/flat/32.png"
         },
         {
            text: "Guam",
            dialCode: "+1671",
            id: "GU",
            flag: "https://www.countryflags.io/GU/flat/32.png"
         },
         {
            text: "Guatemala",
            dialCode: "+502",
            id: "GT",
            flag: "https://www.countryflags.io/GT/flat/32.png"
         },
         {
            text: "Guernsey",
            dialCode: "+44",
            id: "GG",
            flag: "https://www.countryflags.io/GG/flat/32.png"
         },
         {
            text: "Guinea",
            dialCode: "+224",
            id: "GN",
            flag: "https://www.countryflags.io/GN/flat/32.png"
         },
         {
            text: "Guinea-Bissau",
            dialCode: "+245",
            id: "GW",
            flag: "https://www.countryflags.io/GW/flat/32.png"
         },
         {
            text: "Guyana",
            dialCode: "+592",
            id: "GY",
            flag: "https://www.countryflags.io/GY/flat/32.png"
         },
         {
            text: "Haiti",
            dialCode: "+509",
            id: "HT",
            flag: "https://www.countryflags.io/HT/flat/32.png"
         },
         {
            text: "Holy See (Vatican City State)",
            dialCode: "+379",
            id: "VA",
            flag: "https://www.countryflags.io/VA/flat/32.png"
         },
         {
            text: "Honduras",
            dialCode: "+504",
            id: "HN",
            flag: "https://www.countryflags.io/HN/flat/32.png"
         },
         {
            text: "Hong Kong",
            dialCode: "+852",
            id: "HK",
            flag: "https://www.countryflags.io/HK/flat/32.png"
         },
         {
            text: "Hungary",
            dialCode: "+36",
            id: "HU",
            flag: "https://www.countryflags.io/HU/flat/32.png"
         },
         {
            text: "Iceland",
            dialCode: "+354",
            id: "IS",
            flag: "https://www.countryflags.io/IS/flat/32.png"
         },
         {
            text: "India",
            dialCode: "+91",
            id: "IN",
            flag: "https://www.countryflags.io/IN/flat/32.png"
         },
         {
            text: "Indonesia",
            dialCode: "+62",
            id: "ID",
            flag: "https://www.countryflags.io/ID/flat/32.png"
         },
         {
            text: "Iran",
            dialCode: "+98",
            id: "IR",
            flag: "https://www.countryflags.io/IR/flat/32.png"
         },
         {
            text: "Iraq",
            dialCode: "+964",
            id: "IQ",
            flag: "https://www.countryflags.io/IQ/flat/32.png"
         },
         {
            text: "Ireland",
            dialCode: "+353",
            id: "IE",
            flag: "https://www.countryflags.io/IE/flat/32.png"
         },
         {
            text: "Isle of Man",
            dialCode: "+44",
            id: "IM",
            flag: "https://www.countryflags.io/IM/flat/32.png"
         },
         {
            text: "Israel",
            dialCode: "+972",
            id: "IL",
            flag: "https://www.countryflags.io/IL/flat/32.png"
         },
         {
            text: "Italy",
            dialCode: "+39",
            id: "IT",
            flag: "https://www.countryflags.io/IT/flat/32.png"
         },
         {
            text: "Ivory Coast / Cote d'Ivoire",
            dialCode: "+225",
            id: "CI",
            flag: "https://www.countryflags.io/CI/flat/32.png"
         },
         {
            text: "Jamaica",
            dialCode: "+1876",
            id: "JM",
            flag: "https://www.countryflags.io/JM/flat/32.png"
         },
         {
            text: "Japan",
            dialCode: "+81",
            id: "JP",
            flag: "https://www.countryflags.io/JP/flat/32.png"
         },
         {
            text: "Jersey",
            dialCode: "+44",
            id: "JE",
            flag: "https://www.countryflags.io/JE/flat/32.png"
         },
         {
            text: "Jordan",
            dialCode: "+962",
            id: "JO",
            flag: "https://www.countryflags.io/JO/flat/32.png"
         },
         {
            text: "Kazakhstan",
            dialCode: "+77",
            id: "KZ",
            flag: "https://www.countryflags.io/KZ/flat/32.png"
         },
         {
            text: "Kenya",
            dialCode: "+254",
            id: "KE",
            flag: "https://www.countryflags.io/KE/flat/32.png"
         },
         {
            text: "Kiribati",
            dialCode: "+686",
            id: "KI",
            flag: "https://www.countryflags.io/KI/flat/32.png"
         },
         {
            text: "Korea, Democratic People's Republic of Korea",
            dialCode: "+850",
            id: "KP",
            flag: "https://www.countryflags.io/KP/flat/32.png"
         },
         {
            text: "Korea, Republic of South Korea",
            dialCode: "+82",
            id: "KR",
            flag: "https://www.countryflags.io/KR/flat/32.png"
         },
         {
            text: "Kosovo",
            dialCode: "+383",
            id: "XK",
            flag: "https://www.countryflags.io/XK/flat/32.png"
         },
         {
            text: "Kuwait",
            dialCode: "+965",
            id: "KW",
            flag: "https://www.countryflags.io/KW/flat/32.png"
         },
         {
            text: "Kyrgyzstan",
            dialCode: "+996",
            id: "KG",
            flag: "https://www.countryflags.io/KG/flat/32.png"
         },
         {
            text: "Laos",
            dialCode: "+856",
            id: "LA",
            flag: "https://www.countryflags.io/LA/flat/32.png"
         },
         {
            text: "Latvia",
            dialCode: "+371",
            id: "LV",
            flag: "https://www.countryflags.io/LV/flat/32.png"
         },
         {
            text: "Lebanon",
            dialCode: "+961",
            id: "LB",
            flag: "https://www.countryflags.io/LB/flat/32.png"
         },
         {
            text: "Lesotho",
            dialCode: "+266",
            id: "LS",
            flag: "https://www.countryflags.io/LS/flat/32.png"
         },
         {
            text: "Liberia",
            dialCode: "+231",
            id: "LR",
            flag: "https://www.countryflags.io/LR/flat/32.png"
         },
         {
            text: "Libya",
            dialCode: "+218",
            id: "LY",
            flag: "https://www.countryflags.io/LY/flat/32.png"
         },
         {
            text: "Liechtenstein",
            dialCode: "+423",
            id: "LI",
            flag: "https://www.countryflags.io/LI/flat/32.png"
         },
         {
            text: "Lithuania",
            dialCode: "+370",
            id: "LT",
            flag: "https://www.countryflags.io/LT/flat/32.png"
         },
         {
            text: "Luxembourg",
            dialCode: "+352",
            id: "LU",
            flag: "https://www.countryflags.io/LU/flat/32.png"
         },
         {
            text: "Macau",
            dialCode: "+853",
            id: "MO",
            flag: "https://www.countryflags.io/MO/flat/32.png"
         },
         {
            text: "Madagascar",
            dialCode: "+261",
            id: "MG",
            flag: "https://www.countryflags.io/MG/flat/32.png"
         },
         {
            text: "Malawi",
            dialCode: "+265",
            id: "MW",
            flag: "https://www.countryflags.io/MW/flat/32.png"
         },
         {
            text: "Malaysia",
            dialCode: "+60",
            id: "MY",
            flag: "https://www.countryflags.io/MY/flat/32.png"
         },
         {
            text: "Maldives",
            dialCode: "+960",
            id: "MV",
            flag: "https://www.countryflags.io/MV/flat/32.png"
         },
         {
            text: "Mali",
            dialCode: "+223",
            id: "ML",
            flag: "https://www.countryflags.io/ML/flat/32.png"
         },
         {
            text: "Malta",
            dialCode: "+356",
            id: "MT",
            flag: "https://www.countryflags.io/MT/flat/32.png"
         },
         {
            text: "Marshall Islands",
            dialCode: "+692",
            id: "MH",
            flag: "https://www.countryflags.io/MH/flat/32.png"
         },
         {
            text: "Martinique",
            dialCode: "+596",
            id: "MQ",
            flag: "https://www.countryflags.io/MQ/flat/32.png"
         },
         {
            text: "Mauritania",
            dialCode: "+222",
            id: "MR",
            flag: "https://www.countryflags.io/MR/flat/32.png"
         },
         {
            text: "Mauritius",
            dialCode: "+230",
            id: "MU",
            flag: "https://www.countryflags.io/MU/flat/32.png"
         },
         {
            text: "Mayotte",
            dialCode: "+262",
            id: "YT",
            flag: "https://www.countryflags.io/YT/flat/32.png"
         },
         {
            text: "Mexico",
            dialCode: "+52",
            id: "MX",
            flag: "https://www.countryflags.io/MX/flat/32.png"
         },
         {
            text: "Micronesia, Federated States of Micronesia",
            dialCode: "+691",
            id: "FM",
            flag: "https://www.countryflags.io/FM/flat/32.png"
         },
         {
            text: "Moldova",
            dialCode: "+373",
            id: "MD",
            flag: "https://www.countryflags.io/MD/flat/32.png"
         },
         {
            text: "Monaco",
            dialCode: "+377",
            id: "MC",
            flag: "https://www.countryflags.io/MC/flat/32.png"
         },
         {
            text: "Mongolia",
            dialCode: "+976",
            id: "MN",
            flag: "https://www.countryflags.io/MN/flat/32.png"
         },
         {
            text: "Montenegro",
            dialCode: "+382",
            id: "ME",
            flag: "https://www.countryflags.io/ME/flat/32.png"
         },
         {
            text: "Montserrat",
            dialCode: "+1664",
            id: "MS",
            flag: "https://www.countryflags.io/MS/flat/32.png"
         },
         {
            text: "Morocco",
            dialCode: "+212",
            id: "MA",
            flag: "https://www.countryflags.io/MA/flat/32.png"
         },
         {
            text: "Mozambique",
            dialCode: "+258",
            id: "MZ",
            flag: "https://www.countryflags.io/MZ/flat/32.png"
         },
         {
            text: "Myanmar",
            dialCode: "+95",
            id: "MM",
            flag: "https://www.countryflags.io/MM/flat/32.png"
         },
         {
            text: "Namibia",
            dialCode: "+264",
            id: "NA",
            flag: "https://www.countryflags.io/NA/flat/32.png"
         },
         {
            text: "Nauru",
            dialCode: "+674",
            id: "NR",
            flag: "https://www.countryflags.io/NR/flat/32.png"
         },
         {
            text: "Nepal",
            dialCode: "+977",
            id: "NP",
            flag: "https://www.countryflags.io/NP/flat/32.png"
         },
         {
            text: "Netherlands",
            dialCode: "+31",
            id: "NL",
            flag: "https://www.countryflags.io/NL/flat/32.png"
         },
         {
            text: "Netherlands Antilles",
            dialCode: "+599",
            id: "AN",
            flag: "https://www.countryflags.io/AN/flat/32.png"
         },
         {
            text: "New Caledonia",
            dialCode: "+687",
            id: "NC",
            flag: "https://www.countryflags.io/NC/flat/32.png"
         },
         {
            text: "New Zealand",
            dialCode: "+64",
            id: "NZ",
            flag: "https://www.countryflags.io/NZ/flat/32.png"
         },
         {
            text: "Nicaragua",
            dialCode: "+505",
            id: "NI",
            flag: "https://www.countryflags.io/NI/flat/32.png"
         },
         {
            text: "Niger",
            dialCode: "+227",
            id: "NE",
            flag: "https://www.countryflags.io/NE/flat/32.png"
         },
         {
            text: "Nigeria",
            dialCode: "+234",
            id: "NG",
            flag: "https://www.countryflags.io/NG/flat/32.png"
         },
         {
            text: "Niue",
            dialCode: "+683",
            id: "NU",
            flag: "https://www.countryflags.io/NU/flat/32.png"
         },
         {
            text: "Norfolk Island",
            dialCode: "+672",
            id: "NF",
            flag: "https://www.countryflags.io/NF/flat/32.png"
         },
         {
            text: "North Macedonia",
            dialCode: "+389",
            id: "MK",
            flag: "https://www.countryflags.io/MK/flat/32.png"
         },
         {
            text: "Northern Mariana Islands",
            dialCode: "+1670",
            id: "MP",
            flag: "https://www.countryflags.io/MP/flat/32.png"
         },
         {
            text: "Norway",
            dialCode: "+47",
            id: "NO",
            flag: "https://www.countryflags.io/NO/flat/32.png"
         },
         {
            text: "Oman",
            dialCode: "+968",
            id: "OM",
            flag: "https://www.countryflags.io/OM/flat/32.png"
         },
         {
            text: "Pakistan",
            dialCode: "+92",
            id: "PK",
            flag: "https://www.countryflags.io/PK/flat/32.png"
         },
         {
            text: "Palau",
            dialCode: "+680",
            id: "PW",
            flag: "https://www.countryflags.io/PW/flat/32.png"
         },
         {
            text: "Palestine",
            dialCode: "+970",
            id: "PS",
            flag: "https://www.countryflags.io/PS/flat/32.png"
         },
         {
            text: "Panama",
            dialCode: "+507",
            id: "PA",
            flag: "https://www.countryflags.io/PA/flat/32.png"
         },
         {
            text: "Papua New Guinea",
            dialCode: "+675",
            id: "PG",
            flag: "https://www.countryflags.io/PG/flat/32.png"
         },
         {
            text: "Paraguay",
            dialCode: "+595",
            id: "PY",
            flag: "https://www.countryflags.io/PY/flat/32.png"
         },
         {
            text: "Peru",
            dialCode: "+51",
            id: "PE",
            flag: "https://www.countryflags.io/PE/flat/32.png"
         },
         {
            text: "Philippines",
            dialCode: "+63",
            id: "PH",
            flag: "https://www.countryflags.io/PH/flat/32.png"
         },
         {
            text: "Pitcairn",
            dialCode: "+872",
            id: "PN",
            flag: "https://www.countryflags.io/PN/flat/32.png"
         },
         {
            text: "Poland",
            dialCode: "+48",
            id: "PL",
            flag: "https://www.countryflags.io/PL/flat/32.png"
         },
         {
            text: "Portugal",
            dialCode: "+351",
            id: "PT",
            flag: "https://www.countryflags.io/PT/flat/32.png"
         },
         {
            text: "Puerto Rico",
            dialCode: "+1939",
            id: "PR",
            flag: "https://www.countryflags.io/PR/flat/32.png"
         },
         {
            text: "Qatar",
            dialCode: "+974",
            id: "QA",
            flag: "https://www.countryflags.io/QA/flat/32.png"
         },
         {
            text: "Reunion",
            dialCode: "+262",
            id: "RE",
            flag: "https://www.countryflags.io/RE/flat/32.png"
         },
         {
            text: "Romania",
            dialCode: "+40",
            id: "RO",
            flag: "https://www.countryflags.io/RO/flat/32.png"
         },
         {
            text: "Russia",
            dialCode: "+7",
            id: "RU",
            flag: "https://www.countryflags.io/RU/flat/32.png"
         },
         {
            text: "Rwanda",
            dialCode: "+250",
            id: "RW",
            flag: "https://www.countryflags.io/RW/flat/32.png"
         },
         {
            text: "Saint Barthelemy",
            dialCode: "+590",
            id: "BL",
            flag: "https://www.countryflags.io/BL/flat/32.png"
         },
         {
            text: "Saint Helena, Ascension and Tristan Da Cunha",
            dialCode: "+290",
            id: "SH",
            flag: "https://www.countryflags.io/SH/flat/32.png"
         },
         {
            text: "Saint Kitts and Nevis",
            dialCode: "+1869",
            id: "KN",
            flag: "https://www.countryflags.io/KN/flat/32.png"
         },
         {
            text: "Saint Lucia",
            dialCode: "+1758",
            id: "LC",
            flag: "https://www.countryflags.io/LC/flat/32.png"
         },
         {
            text: "Saint Martin",
            dialCode: "+590",
            id: "MF",
            flag: "https://www.countryflags.io/MF/flat/32.png"
         },
         {
            text: "Saint Pierre and Miquelon",
            dialCode: "+508",
            id: "PM",
            flag: "https://www.countryflags.io/PM/flat/32.png"
         },
         {
            text: "Saint Vincent and the Grenadines",
            dialCode: "+1784",
            id: "VC",
            flag: "https://www.countryflags.io/VC/flat/32.png"
         },
         {
            text: "Samoa",
            dialCode: "+685",
            id: "WS",
            flag: "https://www.countryflags.io/WS/flat/32.png"
         },
         {
            text: "San Marino",
            dialCode: "+378",
            id: "SM",
            flag: "https://www.countryflags.io/SM/flat/32.png"
         },
         {
            text: "Sao Tome and Principe",
            dialCode: "+239",
            id: "ST",
            flag: "https://www.countryflags.io/ST/flat/32.png"
         },
         {
            text: "Saudi Arabia",
            dialCode: "+966",
            id: "SA",
            flag: "https://www.countryflags.io/SA/flat/32.png"
         },
         {
            text: "Senegal",
            dialCode: "+221",
            id: "SN",
            flag: "https://www.countryflags.io/SN/flat/32.png"
         },
         {
            text: "Serbia",
            dialCode: "+381",
            id: "RS",
            flag: "https://www.countryflags.io/RS/flat/32.png"
         },
         {
            text: "Seychelles",
            dialCode: "+248",
            id: "SC",
            flag: "https://www.countryflags.io/SC/flat/32.png"
         },
         {
            text: "Sierra Leone",
            dialCode: "+232",
            id: "SL",
            flag: "https://www.countryflags.io/SL/flat/32.png"
         },
         {
            text: "Singapore",
            dialCode: "+65",
            id: "SG",
            flag: "https://www.countryflags.io/SG/flat/32.png"
         },
         {
            text: "Sint Maarten",
            dialCode: "+1721",
            id: "SX",
            flag: "https://www.countryflags.io/SX/flat/32.png"
         },
         {
            text: "Slovakia",
            dialCode: "+421",
            id: "SK",
            flag: "https://www.countryflags.io/SK/flat/32.png"
         },
         {
            text: "Slovenia",
            dialCode: "+386",
            id: "SI",
            flag: "https://www.countryflags.io/SI/flat/32.png"
         },
         {
            text: "Solomon Islands",
            dialCode: "+677",
            id: "SB",
            flag: "https://www.countryflags.io/SB/flat/32.png"
         },
         {
            text: "Somalia",
            dialCode: "+252",
            id: "SO",
            flag: "https://www.countryflags.io/SO/flat/32.png"
         },
         {
            text: "South Africa",
            dialCode: "+27",
            id: "ZA",
            flag: "https://www.countryflags.io/ZA/flat/32.png"
         },
         {
            text: "South Georgia and the South Sandwich Islands",
            dialCode: "+500",
            id: "GS",
            flag: "https://www.countryflags.io/GS/flat/32.png"
         },
         {
            text: "South Sudan",
            dialCode: "+211",
            id: "SS",
            flag: "https://www.countryflags.io/SS/flat/32.png"
         },
         {
            text: "Spain",
            dialCode: "+34",
            id: "ES",
            flag: "https://www.countryflags.io/ES/flat/32.png"
         },
         {
            text: "Sri Lanka",
            dialCode: "+94",
            id: "LK",
            flag: "https://www.countryflags.io/LK/flat/32.png"
         },
         {
            text: "Sudan",
            dialCode: "+249",
            id: "SD",
            flag: "https://www.countryflags.io/SD/flat/32.png"
         },
         {
            text: "Suriname",
            dialCode: "+597",
            id: "SR",
            flag: "https://www.countryflags.io/SR/flat/32.png"
         },
         {
            text: "Svalbard and Jan Mayen",
            dialCode: "+47",
            id: "SJ",
            flag: "https://www.countryflags.io/SJ/flat/32.png"
         },
         {
            text: "Sweden",
            dialCode: "+46",
            id: "SE",
            flag: "https://www.countryflags.io/SE/flat/32.png"
         },
         {
            text: "Switzerland",
            dialCode: "+41",
            id: "CH",
            flag: "https://www.countryflags.io/CH/flat/32.png"
         },
         {
            text: "Syrian Arab Republic",
            dialCode: "+963",
            id: "SY",
            flag: "https://www.countryflags.io/SY/flat/32.png"
         },
         {
            text: "Taiwan",
            dialCode: "+886",
            id: "TW",
            flag: "https://www.countryflags.io/TW/flat/32.png"
         },
         {
            text: "Tajikistan",
            dialCode: "+992",
            id: "TJ",
            flag: "https://www.countryflags.io/TJ/flat/32.png"
         },
         {
            text: "Tanzania, United Republic of Tanzania",
            dialCode: "+255",
            id: "TZ",
            flag: "https://www.countryflags.io/TZ/flat/32.png"
         },
         {
            text: "Thailand",
            dialCode: "+66",
            id: "TH",
            flag: "https://www.countryflags.io/TH/flat/32.png"
         },
         {
            text: "Timor-Leste",
            dialCode: "+670",
            id: "TL",
            flag: "https://www.countryflags.io/TL/flat/32.png"
         },
         {
            text: "Togo",
            dialCode: "+228",
            id: "TG",
            flag: "https://www.countryflags.io/TG/flat/32.png"
         },
         {
            text: "Tokelau",
            dialCode: "+690",
            id: "TK",
            flag: "https://www.countryflags.io/TK/flat/32.png"
         },
         {
            text: "Tonga",
            dialCode: "+676",
            id: "TO",
            flag: "https://www.countryflags.io/TO/flat/32.png"
         },
         {
            text: "Trinidad and Tobago",
            dialCode: "+1868",
            id: "TT",
            flag: "https://www.countryflags.io/TT/flat/32.png"
         },
         {
            text: "Tunisia",
            dialCode: "+216",
            id: "TN",
            flag: "https://www.countryflags.io/TN/flat/32.png"
         },
         {
            text: "Turkey",
            dialCode: "+90",
            id: "TR",
            flag: "https://www.countryflags.io/TR/flat/32.png"
         },
         {
            text: "Turkmenistan",
            dialCode: "+993",
            id: "TM",
            flag: "https://www.countryflags.io/TM/flat/32.png"
         },
         {
            text: "Turks and Caicos Islands",
            dialCode: "+1649",
            id: "TC",
            flag: "https://www.countryflags.io/TC/flat/32.png"
         },
         {
            text: "Tuvalu",
            dialCode: "+688",
            id: "TV",
            flag: "https://www.countryflags.io/TV/flat/32.png"
         },
         {
            text: "Uganda",
            dialCode: "+256",
            id: "UG",
            flag: "https://www.countryflags.io/UG/flat/32.png"
         },
         {
            text: "Ukraine",
            dialCode: "+380",
            id: "UA",
            flag: "https://www.countryflags.io/UA/flat/32.png"
         },
         {
            text: "United Arab Emirates",
            dialCode: "+971",
            id: "AE",
            flag: "https://www.countryflags.io/AE/flat/32.png"
         },
         {
            text: "United Kingdom",
            dialCode: "+44",
            id: "GB",
            flag: "https://www.countryflags.io/GB/flat/32.png"
         },
         {
            text: "United States",
            dialCode: "+1",
            id: "US",
            flag: "https://www.countryflags.io/US/flat/32.png"
         },
         {
            text: "Uruguay",
            dialCode: "+598",
            id: "UY",
            flag: "https://www.countryflags.io/UY/flat/32.png"
         },
         {
            text: "Uzbekistan",
            dialCode: "+998",
            id: "UZ",
            flag: "https://www.countryflags.io/UZ/flat/32.png"
         },
         {
            text: "Vanuatu",
            dialCode: "+678",
            id: "VU",
            flag: "https://www.countryflags.io/VU/flat/32.png"
         },
         {
            text: "Venezuela, Bolivarian Republic of Venezuela",
            dialCode: "+58",
            id: "VE",
            flag: "https://www.countryflags.io/VE/flat/32.png"
         },
         {
            text: "Vietnam",
            dialCode: "+84",
            id: "VN",
            flag: "https://www.countryflags.io/VN/flat/32.png"
         },
         {
            text: "Virgin Islands, British",
            dialCode: "+1284",
            id: "VG",
            flag: "https://www.countryflags.io/VG/flat/32.png"
         },
         {
            text: "Virgin Islands, U.S.",
            dialCode: "+1340",
            id: "VI",
            flag: "https://www.countryflags.io/VI/flat/32.png"
         },
         {
            text: "Wallis and Futuna",
            dialCode: "+681",
            id: "WF",
            flag: "https://www.countryflags.io/WF/flat/32.png"
         },
         {
            text: "Yemen",
            dialCode: "+967",
            id: "YE",
            flag: "https://www.countryflags.io/YE/flat/32.png"
         },
         {
            text: "Zambia",
            dialCode: "+260",
            id: "ZM",
            flag: "https://www.countryflags.io/ZM/flat/32.png"
         },
         {
            text: "Zimbabwe",
            dialCode: "+263",
            id: "ZW",
            flag: "https://www.countryflags.io/ZW/flat/32.png"
         }
      ]

      function formatCountry(country) {
         if (!country.id) { return country.text; }
         console.log(country);
         var $country = $(
            '<span class="flag-icon flag-icon-' + country.id.toLowerCase() + '"><img src="' + country.flag + '" alt="Flag of ' + country.text + '"/></span>' +
            '<span class="flag-text">' + country.text + "</span>"
         );
         return $country;
      };

      function formatCountryCoad(country) {
         if (!country.id) { return country.text; }
         console.log(country);
         var $country = $(
            '<span class="flag-icon flag-icon-' + country.id.toLowerCase() + '"><img src="' + country.flag + '" alt="Flag of ' + country.text + '"/></span>' +
            '<span class="flag-text">' + country.id + ' ' + country.dialCode + "</span>"
         );
         return $country;
      };

      function countryCoadSelect(country) {
         if (!country.id) { return country.text; }
         console.log(country);
         var $country = $(
            '<span class="flag-icon flag-icon-' + country.id.toLowerCase() + '"><img src="' + country.flag + '" alt="Flag of ' + country.text + '"/></span>' +
            '<span class="flag-text">' + country.dialCode + "</span>"
         );
         return $country;
      };

      //Assuming you have a select element with name country
      // e.g. <select name="name"></select>

      setTimeout(function () {
         if ($("[name='country']").length) {
            $("[name='country']").select2({
               placeholder: "Select a country",
               templateResult: formatCountry,
               data: isoCountries
            });
         }

         if ($("[name='countryDialCode']").length) {
            $("[name='countryDialCode']").select2({
               placeholder: "Select country code",
               templateSelection: countryCoadSelect,
               templateResult: formatCountryCoad,
               data: isoCountries
            });
         }
      }, 100)
   })

})(jQuery);