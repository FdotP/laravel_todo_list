<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Reminder</title>
</head>
<body>
    <h1>Task Reminder:jee</h1>
    <p>Hi,</p>
    <p>This is a reminder for your upcoming task:</p>
    <ul>
        <li><strong>Task Name:</strong>{{ $todo->Name }}</li>
        <li><strong>Description:</strong> {{$todo->Description}}</li>
        <li><strong>Due Date:</strong> {{$todo->Execution_Date}}</li>
    </ul>
    <p>Don't forget to complete it on time!</p>
</body>
</html>
