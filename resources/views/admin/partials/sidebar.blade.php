<aside style="background:#fff; border-right:1px solid #e5e7eb; display:flex; flex-direction:column; justify-content:space-between;">
    <div>
        <div style="height:76px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; padding:0 20px; gap:10px;">
            <div style="width:30px; height:30px; border-radius:8px; background:#10b981; color:#fff; display:grid; place-items:center; font-weight:700;">✓</div>
            <div style="font-size:22px; font-weight:700;">SkinCare</div>
        </div>

        <nav style="padding:18px 14px; display:flex; flex-direction:column; gap:6px;">
            <a href="{{ route('admin.dashboard') }}" style="padding:11px 14px; border-radius:10px; text-decoration:none; color:{{ request()->routeIs('admin.dashboard') ? '#059669' : '#4b5563' }}; background:{{ request()->routeIs('admin.dashboard') ? '#e8f5ee' : 'transparent' }}; font-weight:600;">📈 Dashboard</a>
            <a href="{{ route('admin.skin-types.index') }}" style="padding:11px 14px; border-radius:10px; text-decoration:none; color:{{ request()->routeIs('admin.skin-types.*') ? '#059669' : '#4b5563' }}; background:{{ request()->routeIs('admin.skin-types.*') ? '#e8f5ee' : 'transparent' }}; font-weight:600;">💧 Skin Types</a>
            <a href="{{ route('admin.products.index') }}" style="padding:11px 14px; border-radius:10px; text-decoration:none; color:{{ request()->routeIs('admin.products.*') ? '#059669' : '#4b5563' }}; background:{{ request()->routeIs('admin.products.*') ? '#e8f5ee' : 'transparent' }}; font-weight:600;">👜 Products</a>
            <a href="{{ route('admin.predictions.index') }}" style="padding:11px 14px; border-radius:10px; text-decoration:none; color:{{ request()->routeIs('admin.predictions.*') ? '#059669' : '#4b5563' }}; background:{{ request()->routeIs('admin.predictions.*') ? '#e8f5ee' : 'transparent' }}; font-weight:600;">🧠 Prediction Results</a>
        </nav>
    </div>

    <div style="padding:16px 14px; border-top:1px solid #e5e7eb;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="border:none; background:none; color:#ef4444; font-weight:700; font-size:16px; cursor:pointer; padding:10px 14px;">↪ Logout</button>
        </form>
    </div>
</aside>
