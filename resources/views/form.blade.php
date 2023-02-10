<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>



    <div class="container">

    <form method="POST" enctype="multipart/form-data" action="/form/submit">
        @csrf
        <div class="form-group">
          <label for="email">ইমেইল</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="name">দরপত্র দাখিলকারী ব্যক্তি/প্রতিষ্ঠানের নাম</label>
          <input type="text" class="form-control" id="name" name="applicant_orgName" required>
        </div>
        <div class="form-group">
          <label for="address">ঠিকানা</label>
          <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
          <label for="mobile">মোবাইল নম্বর</label>
          <input type="tel" class="form-control" id="mobile" name="mobile" required>
        </div>
        <div class="form-group">
          <label for="deposit">দাখিলকৃত দর (অংকে এবং কথায় উল্লেখ করুন)</label>
          <input type="text" class="form-control" id="deposit" name="depositAmount" required>
        </div>
        <div class="form-group">
          <label for="amount">৩০% জামানত হিসেবে ব্যাংক ড্রাফট/পে অর্ডারের পরিমাণ</label>
          <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
          <label for="bank_draft_image">ব্যাংক ড্রাফট এর ছবি আপলোড করুন</label>
          <input type="file" class="form-control" id="bank_draft_image" name="bank_draft_image" required>
        </div>
        <div class="form-group">
          <label for="deposit_details">দরপত্র সিডিউল আপলোড করুন</label>
          <input type="file" class="form-control" id="deposit_details" name="deposit_details" required>
        </div>
        <button type="submit">জমা দিন</button>
      </form>

    </div>
</body>
</html>
