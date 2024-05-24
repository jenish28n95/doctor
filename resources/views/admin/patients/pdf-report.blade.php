<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <style>
    /* Define your styles for header and footer here */
    .header {
      position: fixed;
      left: 0;
      right: 0;
      height: 100px;
      /* Adjust as needed */
      /* background-color: #333; */
      /* border: 1px solid #000; */
      color: #000;
      text-align: center;
      padding: 10px;
      top: -120px;
      /* Ensure the header is at the top of each page */
    }

    .footer {
      position: fixed;
      bottom: -70px;
      left: 0;
      right: 0;
      height: 50px;
      /* Adjust as needed */
      /* background-color: #333; */
      /* border: 1px solid #000; */
      color: #000;
      text-align: center;
      padding: 10px;
    }

    .content {
      width: 90%;
      margin-top: -120px;
      margin-left: auto;
      margin-right: auto;
      /* Adjust to match header height */
      margin-bottom: 20px;
      /* Adjust based on footer height */
    }

    /* Apply different styles to the header on the first page */
    @page {
      margin: 120px 0 70px;
      /* Adjust based on header and footer height */
    }

    @page: first {
      .header {
        top: -100px;
        /* Move the header up by its height */
      }
    }
  </style>
</head>

<body>
  <div class="header">
    <!-- Header Content -->
  </div>

  <div class="footer">
    <!-- Footer Content -->
  </div>

  <div class="content">
    <!-- Your content here -->
    {!! $content !!}
  </div>
</body>

</html>