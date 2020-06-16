<table>
    <tr>
        <td>Тип форми:</td>
        <td> {{ $title }}</td>
    </tr>
    <tr>
        <td>{{ $appendsData['selectedStep1Title'] }}</td>
        <td>{{ $appendsData['selectedStep1Value'] }}</td>
    </tr>
    <tr>
        <td>{{ $appendsData['selectedStep2Title'] }}</td>
        <td>{{ $appendsData['selectedStep2Value'] }}</td>
    </tr>
    <tr>
        <td>Користувач:</td>
        <td>{{ "{$first_name} {$middle_name} {$last_name}"  }}</td>
    </tr>
    <tr>
        <td>Компанія:</td>
        <td>{{ $name_or_lei }}</td>
    </tr>
    <tr>
        <td>Email:</td>
        <td>{{ $email }}</td>
    </tr>
    <tr>
        <td>Телефон:</td>
        <td>{{ $phone }}</td>
    </tr>
    <tr>
        <td>Повідомлення:</td>
        <td>{{ $inquiry_text }}</td>
    </tr>
</table>