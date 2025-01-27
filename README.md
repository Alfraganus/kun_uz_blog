# Test vazifa - kun.uz

Ushbu loyiha test vazifasi sifatida **kun.uz** uchun bajarildi.

Bajaruvchi: **G‘ulomjon Sulaymonov**

---

## Talablar

### PHP talablari:
- PHP versiyasi: **PHP-8.2**

### Muhim ma’lumot:
- Loyihada `.osp` nomli papka mavjud.
  Ushbu katalog **OpenServer 6.0** uchun ishlatiladi. Agar siz OpenServer ishlatmasangiz, ushbu katalogni e’tiborsiz qoldirishingiz mumkin.

---

## O‘rnatish va ishga tushirish

1. **php yii migrate** buyrug‘ini bajaring.  

2. **php yii init/make-env** buyrug‘ini bajaring (to‘g‘ri `.env` sozlamalarini o‘rnatish yoki ular mavjud bo‘lmasa, yaratish uchun).

3. **php yii init/start** buyrug‘ini bajaring. Bu sozlamalarni to‘liq moslashtirish uchun xizmat qiladi, masalan:
   - ma’lumotlar bazasini yaratish,
   - migratsiyalarni bajarish,
   - admin foydalanuvchi yaratish va boshqalar

## Tugallanmagan vazifalar

 Loyiha dushanba ertalab topshirish reja qilingandi, shunga oyihani bajarish jarayonida quyidagi vazifa uchun vaqt yetishmadi:

- Kategoriyalar uchun tarjimalarni yaratish (json shaklida saqlash ko'zda tutilgan).

- ## Kontent turlarini qo‘shish

Loyihada yangi kontent turlarini qo‘shishingiz mumkin. Buni amalga oshirish uchun quyidagilarni bajaring:

1. Yangi `const` (konstantani) yarating.
2. Uni **ContentService**dagi `contentTypes`ga qo‘shing.  
   Joylashuvi: `app\modules\admin\service\ContentService.php`
