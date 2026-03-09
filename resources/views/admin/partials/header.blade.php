<header style="height: 76px; background:#fff; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center; padding: 0 28px;">
    <h1 style="margin:0; font-size:36px; font-weight:700;">@yield('header_title', 'Dashboard Overview')</h1>

    <div style="display:flex; align-items:center; gap:18px;">
        <span style="font-size:20px; color:#6b7280;">🔔</span>
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:38px; height:38px; border-radius:9999px; background:#e5e7eb; display:grid; place-items:center; font-size:18px;">👤</div>
            <div>
                <div style="font-size:14px; font-weight:600;">{{ auth()->user()->name ?? 'Admin User' }}</div>
                <div style="font-size:12px; color:#6b7280;">Administrator</div>
            </div>
        </div>
    </div>
</header>
