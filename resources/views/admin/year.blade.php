<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Financial Year Selection</title>
  <style>
    /* Basic CSS for list view */
    body,
    html {
      height: 100%;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #3c8dbc;
    }

    .card {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 20px;
      background-color: #f9f9f9;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 300px;
    }

    .financial-year-list {
      list-style-type: none;
      padding: 0;
    }

    .financial-year-list li {
      margin-bottom: 10px;
    }

    .financial-year-list label {
      width: 90%;
      display: inline-block;
      cursor: pointer;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fff;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .financial-year-list input[type="radio"] {
      display: none;
    }

    .financial-year-list input[type="radio"]:checked+label {
      background-color: #3c8dbd;
      width: 90%;
      color: #fff;
    }

    .submit-btn {
      display: block;
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      border: none;
      border-radius: 5px;
      background-color: #3c8dbc;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #3c8dbc;
    }
  </style>
</head>

<body>
  <div class="card">
    <h2>Select Financial Year</h2>
    <form id="financial-year-form" action="{{route('setfinancialyear')}}" method="post" onsubmit="return validateForm()">
      @csrf
      <ul class="financial-year-list">
        @foreach($years as $key=>$year)
        <li><input type="radio" id="year_{{$key}}" name="financial_year" value="{{$year->year}}"><label for="year_{{$key}}">{{$year->year}}</label></li>
        <!-- <li><input type="radio" id="year_{{$key}}" name="financial_year" value="{{$year->year}}" @if($loop->first) required @endif><label for="year_{{$key}}">{{$year->year}}</label></li> -->
        <!-- <li><input type="radio" id="year_{{$key}}" name="financial_year" value="{{$year->year}}" @if($loop->first) checked @endif><label for="year_{{$key}}">{{$year->year}}</label></li> -->
        @endforeach
      </ul>
      <button type="submit" name="submit" class="submit-btn">Submit</button>
    </form>
  </div>

  <script>
    function validateForm() {
      var financialYearRadios = document.getElementsByName('financial_year');
      var isFinancialYearSelected = false;

      for (var i = 0; i < financialYearRadios.length; i++) {
        if (financialYearRadios[i].checked) {
          isFinancialYearSelected = true;
          break;
        }
      }

      if (!isFinancialYearSelected) {
        alert('Please select a financial year');
        return false;
      }

      return true;
    }
  </script>

</body>

</html>