<x-app-sidebar>

<style>
.analytics-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:20px;
}

.analytics-card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    text-align:center;
}

.analytics-card h3{
    margin-bottom:10px;
    color:#555;
}

.analytics-card p{
    font-size:30px;
    font-weight:bold;
    color:#2563eb;
}

.info-box{
    background:white;
    padding:20px;
    border-radius:12px;
    margin-top:25px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th,
table td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:left;
}

table th{
    background:#f5f5f5;
}
</style>

<h2>📊 Lecturer Analytics Dashboard</h2>

<div class="analytics-grid">

    <div class="analytics-card">
        <h3>Total Students</h3>
        <p>{{ $students }}</p>
    </div>

    <div class="analytics-card">
        <h3>Total Discussions</h3>
        <p>{{ $discussions }}</p>
    </div>

    <div class="analytics-card">
        <h3>Total Quizzes</h3>
        <p>{{ $quizzes }}</p>
    </div>

</div>

<div class="info-box">

    <h3>System Summary</h3>

    <table>

        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>

        <tr>
            <td>Registered Students</td>
            <td>{{ $students }}</td>
        </tr>

        <tr>
            <td>Available Discussions</td>
            <td>{{ $discussions }}</td>
        </tr>

        <tr>
            <td>Published Quizzes</td>
            <td>{{ $quizzes }}</td>
        </tr>

        <tr>
            <td>Learning Status</td>
            <td>Active</td>
        </tr>

    </table>

</div>

<br>

<a href="{{ route('lecturer.dashboard') }}">
    ← Back to Dashboard
</a>

</x-app-sidebar>