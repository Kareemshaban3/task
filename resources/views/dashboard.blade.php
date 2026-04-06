<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المتجر الاحترافية</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #2ec4b6;
            --danger-color: #e63946;
            --bg-body: #f8f9fa;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Cairo', sans-serif;
            color: #333;
        }

        .nav-pills {
            background: #fff;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
            border-radius: 10px;
            object-fit: cover;
        }

        .discount-badge {
            background-color: var(--danger-color);
            color: white;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .badge-rel {
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
        }

        .view-main-img {
            width: 100%;
            border-radius: 15px;
            object-fit: contain;
            background: #fff;
            border: 1px solid #eee;
        }

        .spinner-border-sm {
            display: none;
        }

        .loading .spinner-border-sm {
            display: inline-block;
        }

        /* تحسين مظهر الوصف في الجدول */
        .desc-truncate {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="fw-bold">لوحة الإدارة الشاملة <span class="text-primary">💎</span></h1>
            <p class="text-muted">نظام إدارة المنتجات والعروض المتطور</p>
        </header>

        <ul class="nav nav-pills nav-justified mb-4 shadow-sm" id="mainTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill"
                    data-bs-target="#products">المنتجات</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#categories">الأقسام
                    الرئيسية</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#subcategories">الأقسام
                    الفرعية</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tags">الأوسمة</button>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="products">
                <div class="card mb-4">
                    <div class="card-header fw-bold text-primary bg-white py-3">إضافة منتج جديد مع وصف وخصم</div>
                    <div class="card-body p-4">
                        <form id="productForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">اسم المنتج</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">السعر الأصلي</label>
                                    <input type="number" name="price" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">نوع الخصم</label>
                                    <select name="discount_type" class="form-select">
                                        <option value="percentage">نسبة (%)</option>
                                        <option value="fixed">مبلغ ثابت</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">قيمة الخصم</label>
                                    <input type="number" name="discount_value" class="form-control" value="0">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">وصف المنتج</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="اكتب تفاصيل المنتج هنا..." required></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الأقسام الفرعية</label>
                                    <select name="sub_category_ids[]" id="sub_select_for_prod" class="form-select"
                                        multiple required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الأوسمة (Tags)</label>
                                    <select name="tag_ids[]" id="tag_select_for_prod" class="form-select"
                                        multiple></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الصورة الرئيسية</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">المرفقات الإضافية</label>
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

                <div class="card shadow-sm">
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>الصورة</th>
                                    <th>المنتج والوصف</th>
                                    <th>التصنيف / الوسم</th>
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
                        <div class="col-md-9"><label class="form-label fw-bold">اسم القسم الرئيسي</label><input
                                type="text" name="name" class="form-control" required></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary w-100">إضافة قسم</button>
                        </div>
                    </form>
                    <table class="table mt-4">
                        <tbody id="catTableBody"></tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="subcategories">
                <div class="card p-4">
                    <form id="subCatForm" class="row g-3 align-items-end">
                        <div class="col-md-5"><label class="form-label fw-bold">اسم القسم الفرعي</label><input
                                type="text" name="name" class="form-control" required></div>
                        <div class="col-md-5"><label class="form-label fw-bold">اربط بالقسم الرئيسي</label><select
                                name="category_ids[]" id="cat_select_for_sub" class="form-select" multiple
                                required></select></div>
                        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">إضافة</button>
                        </div>
                    </form>
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>الفرعي</th>
                                <th>الرئيسي المربوط به</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody id="subCatTableBody"></tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tags">
                <div class="card p-4">
                    <form id="tagForm" class="row g-3 align-items-end">
                        <div class="col-md-9"><input type="text" name="name" class="form-control"
                                placeholder="اسم الوسم" required></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary w-100">إضافة وسم</button>
                        </div>
                    </form>
                    <table class="table mt-4">
                        <tbody id="tagTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-header bg-dark text-white border-0">
                    <h5 class="modal-title">عرض تفاصيل المنتج</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5 bg-light p-4 text-center" id="mainMediaContainer"></div>
                        <div class="col-md-7 p-4">
                            <h3 id="productTitle" class="fw-bold mb-1"></h3>
                            <div id="priceDisplayArea" class="mb-3"></div>

                            <p id="productDescription" class="text-muted small mb-3 border-start ps-3"></p>

                            <div id="badgeContainer" class="mb-3"></div>
                            <hr>
                            <div id="additionalMedia" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            async function apiFetch(url, options = {}) {
                try {
                    const response = await fetch(url, {
                        ...options,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
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
                body.innerHTML = '';
                select.innerHTML = '';
                data.forEach(c => {
                    body.insertAdjacentHTML('beforeend',
                        `<tr><td>${c.id}</td><td>${c.name}</td><td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('categories', ${c.id})">حذف</button></td></tr>`
                        );
                    select.add(new Option(c.name, c.id));
                });
            }

            async function loadSubCategories() {
                const data = await apiFetch('/api/sub-categories');
                if (!data) return;
                const body = document.getElementById('subCatTableBody');
                const select = document.getElementById('sub_select_for_prod');
                body.innerHTML = '';
                select.innerHTML = '';
                data.forEach(s => {
                    const linkedCats = s.categories?.map(c =>
                            `<span class="badge bg-info text-dark ms-1">${c.name}</span>`).join('') ||
                        'غير مرتبط';
                    body.insertAdjacentHTML('beforeend',
                        `<tr><td>${s.name}</td><td>${linkedCats}</td><td><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('sub-categories', ${s.id})">حذف</button></td></tr>`
                        );
                    select.add(new Option(s.name, s.id));
                });
            }

            async function loadTags() {
                const data = await apiFetch('/api/tags');
                if (!data) return;
                const body = document.getElementById('tagTableBody');
                const select = document.getElementById('tag_select_for_prod');
                body.innerHTML = '';
                select.innerHTML = '';
                data.forEach(t => {
                    body.insertAdjacentHTML('beforeend',
                        `<tr><td>${t.name}</td><td class="text-end"><button class="btn btn-outline-danger btn-sm" onclick="deleteItem('tags', ${t.id})">حذف</button></td></tr>`
                        );
                    select.add(new Option(t.name, t.id));
                });
            }

            async function loadProducts() {
                const data = await apiFetch('/api/products');
                if (!data) return;
                const body = document.getElementById('productTableBody');
                body.innerHTML = '';

                data.forEach(p => {
                    const mainImg = p.images?.find(i => i.is_main)?.path || 'default.png';
                    let finalPrice = parseFloat(p.price);
                    let discountLabel = '';
                    const val = parseFloat(p.discount_value) || 0;

                    if (val > 0) {
                        if (p.discount_type === 'percentage') {
                            finalPrice = p.price - (p.price * (val / 100));
                            discountLabel = `<span class="discount-badge">-${val}%</span>`;
                        } else {
                            finalPrice = p.price - val;
                            discountLabel = `<span class="discount-badge">-${val} ج.م</span>`;
                        }
                    }

                    const subs = p.sub_categories?.map(s =>
                            `<span class="badge bg-light text-dark border badge-rel">${s.name}</span>`)
                        .join('') || '';
                    const tags = p.tags?.map(t =>
                        `<span class="badge bg-primary badge-rel">#${t.name}</span>`).join('') || '';

                    body.insertAdjacentHTML('beforeend', `
                        <tr>
                            <td><img src="/storage/${mainImg}" class="img-thumbnail border"></td>
                            <td>
                                <div class="fw-bold">${p.name}</div>
                                <div class="desc-truncate">${p.description || 'لا يوجد وصف'}</div>
                            </td>
                            <td><div>${subs}</div><div>${tags}</div></td>
                            <td>
                                ${val > 0 ? `<div class="text-muted text-decoration-line-through small">${parseFloat(p.price).toFixed(2)}</div>` : ''}
                                <div class="text-primary fw-bold">${finalPrice.toFixed(2)} ج.م ${discountLabel}</div>
                            </td>
                            <td>
                                <button class="btn btn-light btn-sm border" onclick="viewProduct(${p.id})">👀 عرض</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem('products', ${p.id})">حذف</button>
                            </td>
                        </tr>
                    `);
                });
            }

            document.getElementById('productForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const btn = document.getElementById('btnSaveProduct');
                btn.classList.add('loading');
                btn.disabled = true;

                const res = await apiFetch('/api/products', {
                    method: 'POST',
                    body: new FormData(this)
                });
                if (res) {
                    alert('تم الحفظ بنجاح!');
                    this.reset();
                    loadProducts();
                }
                btn.classList.remove('loading');
                btn.disabled = false;
            });

            ['catForm', 'subCatForm', 'tagForm'].forEach(id => {
                document.getElementById(id).addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const url = id === 'catForm' ? '/api/categories' : (id === 'tagForm' ?
                        '/api/tags' : '/api/sub-categories');
                    const res = await apiFetch(url, {
                        method: 'POST',
                        body: new URLSearchParams(new FormData(this))
                    });
                    if (res) {
                        this.reset();
                        loadAll();
                    }
                });
            });

            window.viewProduct = async function(id) {
                const p = await apiFetch(`/api/products/${id}`);
                if (!p) return;

                document.getElementById('productTitle').innerText = p.name;
                document.getElementById('productDescription').innerText = p.description ||
                    'لا يوجد وصف لهذا المنتج.';

                const val = parseFloat(p.discount_value) || 0;
                let finalPrice = parseFloat(p.price);
                if (val > 0) {
                    finalPrice = p.discount_type === 'percentage' ? p.price - (p.price * (val / 100)) : p
                        .price - val;
                }

                document.getElementById('priceDisplayArea').innerHTML = `
                    <h3 class="text-primary fw-bold mb-0">${finalPrice.toFixed(2)} ج.م</h3>
                    ${val > 0 ? `<span class="text-muted text-decoration-line-through">${parseFloat(p.price).toFixed(2)} ج.م</span> <span class="badge bg-danger">وفرت ${p.discount_type === 'percentage' ? val+'%' : val+' ج.م'}</span>` : ''}
                `;

                const subs = p.sub_categories?.map(s => `<span class="badge bg-dark me-1">${s.name}</span>`)
                    .join('') || '';
                document.getElementById('badgeContainer').innerHTML = subs;

                const mainBox = document.getElementById('mainMediaContainer');
                const extraBox = document.getElementById('additionalMedia');
                extraBox.innerHTML = '';

                p.images?.forEach(img => {
                    const url = `/storage/${img.path}`;
                    if (img.is_main) mainBox.innerHTML =
                        `<img src="${url}" class="view-main-img shadow-sm">`;
                    else {
                        let icon = img.file_type === 'video' ? '🎥' : (img.file_type === 'pdf' ?
                            '📄' : '🖼️');
                        extraBox.insertAdjacentHTML('beforeend', `
                            <div class="border rounded p-2 text-center" style="width:70px; cursor:pointer" onclick="window.open('${url}')">
                                <div class="fs-4">${icon}</div><small style="font-size:10px">${img.file_type}</small>
                            </div>`);
                    }
                });

                new bootstrap.Modal('#productViewModal').show();
            };

            window.deleteItem = async function(type, id) {
                if (confirm('هل أنت متأكد؟')) {
                    const res = await apiFetch(`/api/${type}/${id}`, {
                        method: 'DELETE'
                    });
                    if (res) loadAll();
                }
            };
        });
    </script>
</body>

</html>
