<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الشاملة - إدارة اللغات</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --bg-body: #f8f9fa;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Cairo', sans-serif;
            color: #333;
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .img-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }

        .spinner-border-sm {
            display: none;
        }

        .loading .spinner-border-sm {
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-bold">لوحة الإدارة الشاملة <span class="text-primary">💎</span></h1>
                <p class="text-muted">نظام إدارة المنتجات (متعدد اللغات) والأقسام</p>
            </div>
            <div class="bg-white p-2 rounded shadow-sm border">
                <label class="me-2 fw-bold small">لغة العرض:</label>
                <select id="langSwitcher" class="form-select form-select-sm d-inline-block w-auto">
                    <option value="ar">العربية</option>
                    <option value="en">English</option>
                </select>
            </div>
        </header>

        <ul class="nav nav-pills nav-justified mb-4 shadow-sm" id="mainTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#products">المنتجات</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#categories">الأقسام الرئيسية</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#subcategories">الأقسام الفرعية</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tags">الأوسمة</button></li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="products">
                <div class="card mb-4">
                    <div class="card-header fw-bold text-primary bg-white py-3">إضافة منتج جديد (بيانات مزدوجة)</div>
                    <div class="card-body p-4">
                        <form id="productForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">اسم المنتج (بالعربي)</label>
                                    <input type="text" name="name_ar" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Product Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control" dir="ltr" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">وصف المنتج (بالعربي)</label>
                                    <textarea name="description_ar" class="form-control" rows="2" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Description (EN)</label>
                                    <textarea name="description_en" class="form-control" rows="2" dir="ltr" required></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">السعر الأصلي</label>
                                    <input type="number" name="price" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">نوع الخصم</label>
                                    <select name="discount_type" class="form-select">
                                        <option value="percentage">نسبة (%)</option>
                                        <option value="fixed">مبلغ ثابت</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">قيمة الخصم</label>
                                    <input type="number" name="discount_value" class="form-control" value="0">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الأقسام الفرعية</label>
                                    <select name="sub_category_ids[]" id="sub_select_for_prod" class="form-select" multiple required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الأوسمة (Tags)</label>
                                    <select name="tag_ids[]" id="tag_select_for_prod" class="form-select" multiple></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الصورة الرئيسية</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">صور إضافية</label>
                                    <input type="file" name="other_images[]" class="form-control" multiple>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-lg w-100" id="btnSaveProduct">
                                        حفظ المنتج <span class="spinner-border spinner-border-sm"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>الصورة</th>
                                    <th>المنتج والوصف</th>
                                    <th>السعر النهائي</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="categories">
                <div class="card p-4">
                    <form id="catForm" class="row g-3 align-items-end">
                        <div class="col-md-9"><label class="form-label fw-bold">اسم القسم الرئيسي</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary w-100">إضافة قسم</button></div>
                    </form>
                    <table class="table mt-4"><tbody id="catTableBody"></tbody></table>
                </div>
            </div>

            <div class="tab-pane fade" id="subcategories">
                <div class="card p-4">
                    <form id="subCatForm" class="row g-3 align-items-end">
                        <div class="col-md-5"><label class="form-label fw-bold">اسم القسم الفرعي</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-5"><label class="form-label fw-bold">اربط بالرئيسي</label><select name="category_ids[]" id="cat_select_for_sub" class="form-select" multiple required></select></div>
                        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">إضافة</button></div>
                    </form>
                    <table class="table mt-4"><tbody id="subCatTableBody"></tbody></table>
                </div>
            </div>

            <div class="tab-pane fade" id="tags">
                <div class="card p-4">
                    <form id="tagForm" class="row g-3 align-items-end">
                        <div class="col-md-9"><input type="text" name="name" class="form-control" placeholder="اسم الوسم" required></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary w-100">إضافة وسم</button></div>
                    </form>
                    <table class="table mt-4"><tbody id="tagTableBody"></tbody></table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const langSwitcher = document.getElementById('langSwitcher');

            async function apiFetch(url, options = {}) {
                try {
                    const response = await fetch(url, {
                        ...options,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Accept-Language': langSwitcher.value, // يرسل اللغة المختارة للـ Backend
                            ...(options.headers || {})
                        }
                    });
                    if (!response.ok) throw await response.json();
                    return await response.json();
                } catch (err) {
                    alert('خطأ: ' + (err.message || 'فشل الاتصال'));
                    return null;
                }
            }

            // إعادة تحميل البيانات عند تغيير لغة العرض
            langSwitcher.addEventListener('change', loadAll);

            async function loadAll() {
                await loadCategories();
                await loadSubCategories();
                await loadTags();
                await loadProducts();
            }
            loadAll();

            async function loadCategories() {
                const data = await apiFetch('/api/categories');
                if (!data) return;
                const body = document.getElementById('catTableBody');
                const select = document.getElementById('cat_select_for_sub');
                body.innerHTML = ''; select.innerHTML = '';
                data.forEach(c => {
                    body.insertAdjacentHTML('beforeend', `<tr><td>${c.name}</td><td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('categories', ${c.id})">حذف</button></td></tr>`);
                    select.add(new Option(c.name, c.id));
                });
            }

            async function loadSubCategories() {
                const data = await apiFetch('/api/sub-categories');
                if (!data) return;
                const body = document.getElementById('subCatTableBody');
                const select = document.getElementById('sub_select_for_prod');
                body.innerHTML = ''; select.innerHTML = '';
                data.forEach(s => {
                    body.insertAdjacentHTML('beforeend', `<tr><td>${s.name}</td><td><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('sub-categories', ${s.id})">حذف</button></td></tr>`);
                    select.add(new Option(s.name, s.id));
                });
            }

            async function loadTags() {
                const data = await apiFetch('/api/tags');
                if (!data) return;
                const body = document.getElementById('tagTableBody');
                const select = document.getElementById('tag_select_for_prod');
                body.innerHTML = ''; select.innerHTML = '';
                data.forEach(t => {
                    body.insertAdjacentHTML('beforeend', `<tr><td>${t.name}</td><td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('tags', ${t.id})">حذف</button></td></tr>`);
                    select.add(new Option(t.name, t.id));
                });
            }

            async function loadProducts() {
                const data = await apiFetch('/api/products');
                if (!data) return;
                const body = document.getElementById('productTableBody');
                body.innerHTML = '';
                data.forEach(p => {
                    const img = p.images?.find(i => i.is_main)?.path || 'default.png';
                    body.insertAdjacentHTML('beforeend', `
                        <tr>
                            <td><img src="/storage/${img}" class="img-thumbnail border"></td>
                            <td><div class="fw-bold">${p.name}</div><small class="text-muted">${p.description || ''}</small></td>
                            <td><div class="text-primary fw-bold">${parseFloat(p.price).toFixed(2)} ج.م</div></td>
                            <td><button class="btn btn-danger btn-sm" onclick="deleteItem('products', ${p.id})">حذف</button></td>
                        </tr>
                    `);
                });
            }

            document.getElementById('productForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const btn = document.getElementById('btnSaveProduct');
                btn.classList.add('loading'); btn.disabled = true;

                // إرسال FormData الذي يحتوي على name_ar, name_en, description_ar, description_en
                const res = await apiFetch('/api/products', {
                    method: 'POST',
                    body: new FormData(this)
                });

                if (res) { alert('تم حفظ المنتج بنجاح'); this.reset(); loadProducts(); }
                btn.classList.remove('loading'); btn.disabled = false;
            });

            ['catForm', 'subCatForm', 'tagForm'].forEach(id => {
                document.getElementById(id).addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const url = id === 'catForm' ? '/api/categories' : (id === 'tagForm' ? '/api/tags' : '/api/sub-categories');
                    const res = await apiFetch(url, {
                        method: 'POST',
                        body: new URLSearchParams(new FormData(this))
                    });
                    if (res) { this.reset(); loadAll(); }
                });
            });

            window.deleteItem = async function(type, id) {
                if (confirm('هل أنت متأكد؟')) {
                    const res = await apiFetch(`/api/${type}/${id}`, { method: 'DELETE' });
                    if (res) loadAll();
                }
            };
        });
    </script>
</body>

</html>