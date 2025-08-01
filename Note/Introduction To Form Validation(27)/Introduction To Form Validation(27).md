<div dir="rtl">
ابتدا به صفحه ارسال یادداشت رفته و یک یادداشت یا جعبه متن خالی رو ذخیره میکنیم .حالا میبینیم که یک یادداشت خالی ذخیره شده که درست نیست برای کنترل این کار دو راه وجود دارد یکی سمت کاربر و یکی سمت سرور .برای کنترل سمت کاربر مقدار required را در تعریف textarea وارد میکنیم فقط بین برچسب باز و بسته textarea نباید یک فاصله هم باشد پس:
<div dir="ltr">

```html
<div class="mt-2">
    <textarea id="body" 
              name="body"
              placeholder="note text"
              rows="3"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
    required></textarea>
</div>
```
<div dir="rtl">
برای کنترل سمت سرور هم از تابع strlen استفاده میکنیم که کدش رو در زیر آورده ام فقط در اینجا یادداشت هایی رو که بیشتر از 1000 کاراکترهم باشد رو قبول نمیکند :

<div dir="ltr">

# note_create.php
```php
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error =[];
        if(strlen($_POST["body"]) == 0){
            $error["body"] = "Body is required";
        }
        if(strlen($_POST["body"]) > 1000){
            $error["body"] = "body is too long ";
        }
        if(empty($error)){
            $db = new Database($config['database']);
            $db->query("INSERT INTO notes (body,user_id) VALUES (:body ,:user_id)" , ['body' => $_POST['body'], 'user_id' => 3 ]);
        }
    }
```
# notes_create.view.php

```php
<div class="mt-2">
    <textarea id="body"
        name="body"
        placeholder="note text"
        rows="3"
        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        ><?= isset($_POST['body']) ? $_POST['body'] : '' ; ?></textarea>
        <?php if(isset($error['body'])): ?>
              <p class="text-red-500"><?=$error['body'] ?></p>
        <?php endif; ?>
</div>
```