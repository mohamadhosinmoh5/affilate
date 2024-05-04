<input type="" class="form-control" id="{{$row->field}}" type="number" @if($row->required == 1) required @endif
@if(isset($options->min)) min="{{ $options->min }}" @endif
@if(isset($options->max)) max="{{ $options->max }}" @endif
step="{{ $options->step ?? 'any' }}"
placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">

{{-- @php
dd($row)
@endphp --}}

<input type="number" class="form-control " id="{{$row->field}}-main" name="{{ $row->field }}" type="number" style="display: none;" @if($row->required == 1) required @endif
@if(isset($options->min)) min="{{ $options->min }}" @endif
@if(isset($options->max)) max="{{ $options->max }}" @endif
step="{{ $options->step ?? 'any' }}"
placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">

<script>
        document.getElementById('{{$row->field}}').value = separateNumbers('{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}');
        document.getElementById('{{$row->field}}').addEventListener("input", function(e) {
            
        // مقدار ورودی را گرفتن
            let inputNumber = e.target.value;

            // جدا کردن اعداد و تنظیم مقدار ورودی
            e.target.value = separateNumbers(inputNumber);

            var numberString = inputNumber.replace(/,/g, "");
            // console.log(numberString)
            // let result = removeCommas(numberString);
            var inputElementMain = document.getElementById("{{$row->field}}-main");

            console.log(inputElementMain.value)
            $('#{{$row->field}}-main').val(parseInt(numberString));
            // inputElementMain.value = parseInt(numberString)
    });
        
        // console.log(element)
        // inputvalue = element.value
    
        // inputvaluebycomma = separateNumbers(inputvalue)
    
        // element.value = inputvaluebycomma;

    function separateNumbers(inputNumber) {
        // حذف ویرگول‌ها از ورودی
        let numberString = inputNumber.replace(/,/g, "");

        // طول رشته
        let length = numberString.length;

        // ایجاد یک آرایه برای نگهداری اعداد جدا شده
        let separatedNumbers = [];

        // شمارنده برای تعیین مکان شروع جدا کردن
        let startIndex = length % 3;

        // اضافه کردن اعداد اولیه
        if (startIndex !== 0) {
            separatedNumbers.push(numberString.substring(0, startIndex));
        }

        // جدا کردن اعداد به هر سه تایی
        while (startIndex < length) {
            separatedNumbers.push(
                numberString.substring(startIndex, startIndex + 3)
            );
            startIndex += 3;
        }


        // تبدیل آرایه به رشته با ویرگول بین اعداد
        let result = separatedNumbers.join(",");

        // console.log(result)

        return result;
    }

    function removeCommas(inputNumber) {
        // استفاده از عبارت منظم برای حذف ویرگول‌ها
        let result = inputNumber.replace(/,/g, "");
        return result;
    }

    // انتخاب المان ورودی
    // var inputElement = document.getElementsByClassName("num")[0];
    // var inputElementMain = document.getElementsByClassName("main")[0];
    // // console.log(inputElement)

    // // گوش دادن به رویداد input بر روی المان ورودی
    // inputElement.addEventListener("input", function() {
    //     // مقدار ورودی را گرفتن
    //     let inputNumber = inputElement.value;

    //     // جدا کردن اعداد و تنظیم مقدار ورودی
    //     inputElement.value = separateNumbers(inputNumber);

    //     var numberString = inputNumber.replace(/,/g, "");
    //     console.log(numberString)
    //     inputElementMain.value = parseInt(numberString)
    //     // مثال استفاده از تابع
    //     // let inputNumber = separateNumbers(inputNumber);
    //     // let result = removeCommas(inputNumber);
    //     // console.log(result); // نمایش در کنسول: 1234567890
    // });
</script>