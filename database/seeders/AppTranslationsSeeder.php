<?php

namespace Database\Seeders;

use App\Model\LanguageTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Translations for UI strings introduced by the Eurobas mobile app that have
 * no equivalent in the website's existing translation set. Idempotent — safe to
 * run repeatedly.
 *
 *  - $authored : hand-authored strings across all 31 site languages.
 *  - $copyFrom : app key => existing website key; copies that key's (professional)
 *                values for every locale, so the app reuses them verbatim.
 *
 * Keys already present under a reusable website name (filter, post_your_ad,
 * sign_in_with_google) are handled in the app itself and intentionally omitted.
 *
 * To adjust a language, edit below and re-run:
 *   php artisan db:seed --class=AppTranslationsSeeder
 */
class AppTranslationsSeeder extends Seeder
{
    /** key => [locale => value] for all 31 supported locales. */
    private array $authored = [
        'welcome_back' => [
            'en' => 'Welcome back!', 'nl' => 'Welkom terug!', 'de' => 'Willkommen zurück!', 'fr' => 'Bon retour !',
            'es' => '¡Bienvenido de nuevo!', 'it' => 'Bentornato!', 'pt' => 'Bem-vindo de volta!', 'ar' => 'مرحباً بعودتك!',
            'bg' => 'Добре дошли отново!', 'bs' => 'Dobrodošli nazad!', 'cs' => 'Vítejte zpět!', 'da' => 'Velkommen tilbage!',
            'el' => 'Καλώς ήρθατε ξανά!', 'fi' => 'Tervetuloa takaisin!', 'hr' => 'Dobrodošli natrag!', 'hu' => 'Üdvözöljük újra!',
            'ja' => 'おかえりなさい！', 'ko' => '다시 오신 것을 환영합니다!', 'lt' => 'Sveiki sugrįžę!', 'nn' => 'Velkommen tilbake!',
            'pl' => 'Witamy ponownie!', 'ro' => 'Bine ai revenit!', 'ru' => 'С возвращением!', 'sk' => 'Vitajte späť!',
            'sl' => 'Dobrodošli nazaj!', 'sq' => 'Mirë se u ktheve!', 'sr' => 'Добродошли назад!', 'sv' => 'Välkommen tillbaka!',
            'tr' => 'Tekrar hoş geldiniz!', 'uk' => 'З поверненням!', 'zh' => '欢迎回来！',
        ],
        'login_and_enjoy' => [
            'en' => 'Login and Enjoy', 'nl' => 'Log in en geniet', 'de' => 'Anmelden und genießen', 'fr' => 'Connectez-vous et profitez',
            'es' => 'Inicia sesión y disfruta', 'it' => 'Accedi e goditi', 'pt' => 'Entre e aproveite', 'ar' => 'سجّل الدخول واستمتع',
            'bg' => 'Влезте и се насладете', 'bs' => 'Prijavite se i uživajte', 'cs' => 'Přihlaste se a užívejte', 'da' => 'Log ind og nyd',
            'el' => 'Συνδεθείτε και απολαύστε', 'fi' => 'Kirjaudu ja nauti', 'hr' => 'Prijavite se i uživajte', 'hu' => 'Jelentkezzen be és élvezze',
            'ja' => 'ログインして楽しもう', 'ko' => '로그인하고 즐기세요', 'lt' => 'Prisijunkite ir mėgaukitės', 'nn' => 'Logg inn og nyt',
            'pl' => 'Zaloguj się i korzystaj', 'ro' => 'Conectează-te și bucură-te', 'ru' => 'Войдите и наслаждайтесь', 'sk' => 'Prihláste sa a užívajte',
            'sl' => 'Prijavite se in uživajte', 'sq' => 'Hyni dhe shijoni', 'sr' => 'Пријавите се и уживајте', 'sv' => 'Logga in och njut',
            'tr' => 'Giriş yap ve keyfini çıkar', 'uk' => 'Увійдіть і насолоджуйтесь', 'zh' => '登录即享',
        ],
        'dont_have_an_account' => [
            'en' => "Don't have an account?", 'nl' => 'Nog geen account?', 'de' => 'Noch kein Konto?', 'fr' => "Vous n'avez pas de compte ?",
            'es' => '¿No tienes una cuenta?', 'it' => 'Non hai un account?', 'pt' => 'Não tem uma conta?', 'ar' => 'ليس لديك حساب؟',
            'bg' => 'Нямате акаунт?', 'bs' => 'Nemate račun?', 'cs' => 'Nemáte účet?', 'da' => 'Har du ikke en konto?',
            'el' => 'Δεν έχετε λογαριασμό;', 'fi' => 'Eikö sinulla ole tiliä?', 'hr' => 'Nemate račun?', 'hu' => 'Nincs fiókja?',
            'ja' => 'アカウントをお持ちでないですか？', 'ko' => '계정이 없으신가요?', 'lt' => 'Neturite paskyros?', 'nn' => 'Har du ikkje ein konto?',
            'pl' => 'Nie masz konta?', 'ro' => 'Nu ai un cont?', 'ru' => 'Нет аккаунта?', 'sk' => 'Nemáte účet?',
            'sl' => 'Nimate računa?', 'sq' => 'Nuk keni një llogari?', 'sr' => 'Немате налог?', 'sv' => 'Har du inget konto?',
            'tr' => 'Hesabınız yok mu?', 'uk' => 'Немає облікового запису?', 'zh' => '还没有账户？',
        ],
        'create_an_account' => [
            'en' => 'Create an Account', 'nl' => 'Account aanmaken', 'de' => 'Konto erstellen', 'fr' => 'Créer un compte',
            'es' => 'Crear una cuenta', 'it' => 'Crea un account', 'pt' => 'Criar uma conta', 'ar' => 'إنشاء حساب',
            'bg' => 'Създаване на акаунт', 'bs' => 'Kreiraj račun', 'cs' => 'Vytvořit účet', 'da' => 'Opret en konto',
            'el' => 'Δημιουργία λογαριασμού', 'fi' => 'Luo tili', 'hr' => 'Stvori račun', 'hu' => 'Fiók létrehozása',
            'ja' => 'アカウントを作成', 'ko' => '계정 만들기', 'lt' => 'Sukurti paskyrą', 'nn' => 'Opprett ein konto',
            'pl' => 'Utwórz konto', 'ro' => 'Creează un cont', 'ru' => 'Создать аккаунт', 'sk' => 'Vytvoriť účet',
            'sl' => 'Ustvari račun', 'sq' => 'Krijo një llogari', 'sr' => 'Направи налог', 'sv' => 'Skapa ett konto',
            'tr' => 'Hesap oluştur', 'uk' => 'Створити обліковий запис', 'zh' => '创建账户',
        ],
        'choose_your_profile' => [
            'en' => 'Choose your Profile', 'nl' => 'Kies uw profiel', 'de' => 'Wählen Sie Ihr Profil', 'fr' => 'Choisissez votre profil',
            'es' => 'Elige tu perfil', 'it' => 'Scegli il tuo profilo', 'pt' => 'Escolha o seu perfil', 'ar' => 'اختر ملفك الشخصي',
            'bg' => 'Изберете вашия профил', 'bs' => 'Odaberite svoj profil', 'cs' => 'Vyberte svůj profil', 'da' => 'Vælg din profil',
            'el' => 'Επιλέξτε το προφίλ σας', 'fi' => 'Valitse profiilisi', 'hr' => 'Odaberite svoj profil', 'hu' => 'Válassza ki a profilját',
            'ja' => 'プロフィールを選択', 'ko' => '프로필을 선택하세요', 'lt' => 'Pasirinkite savo profilį', 'nn' => 'Vel profilen din',
            'pl' => 'Wybierz swój profil', 'ro' => 'Alege-ți profilul', 'ru' => 'Выберите профиль', 'sk' => 'Vyberte svoj profil',
            'sl' => 'Izberite svoj profil', 'sq' => 'Zgjidhni profilin tuaj', 'sr' => 'Изаберите свој профил', 'sv' => 'Välj din profil',
            'tr' => 'Profilinizi seçin', 'uk' => 'Виберіть свій профіль', 'zh' => '选择您的资料',
        ],
        'choose_app_language' => [
            'en' => 'Choose your language', 'nl' => 'Kies uw taal', 'de' => 'Wählen Sie Ihre Sprache', 'fr' => 'Choisissez votre langue',
            'es' => 'Elige tu idioma', 'it' => 'Scegli la tua lingua', 'pt' => 'Escolha o seu idioma', 'ar' => 'اختر لغتك',
            'bg' => 'Изберете вашия език', 'bs' => 'Odaberite svoj jezik', 'cs' => 'Vyberte svůj jazyk', 'da' => 'Vælg dit sprog',
            'el' => 'Επιλέξτε τη γλώσσα σας', 'fi' => 'Valitse kielesi', 'hr' => 'Odaberite svoj jezik', 'hu' => 'Válassza ki a nyelvét',
            'ja' => '言語を選択', 'ko' => '언어를 선택하세요', 'lt' => 'Pasirinkite savo kalbą', 'nn' => 'Vel språket ditt',
            'pl' => 'Wybierz swój język', 'ro' => 'Alege-ți limba', 'ru' => 'Выберите язык', 'sk' => 'Vyberte svoj jazyk',
            'sl' => 'Izberite svoj jezik', 'sq' => 'Zgjidhni gjuhën tuaj', 'sr' => 'Изаберите свој језик', 'sv' => 'Välj ditt språk',
            'tr' => 'Dilinizi seçin', 'uk' => 'Виберіть свою мову', 'zh' => '选择您的语言',
        ],
        'main_categories' => [
            'en' => 'Main Categories', 'nl' => 'Hoofdcategorieën', 'de' => 'Hauptkategorien', 'fr' => 'Catégories principales',
            'es' => 'Categorías principales', 'it' => 'Categorie principali', 'pt' => 'Categorias principais', 'ar' => 'الفئات الرئيسية',
            'bg' => 'Основни категории', 'bs' => 'Glavne kategorije', 'cs' => 'Hlavní kategorie', 'da' => 'Hovedkategorier',
            'el' => 'Κύριες κατηγορίες', 'fi' => 'Pääkategoriat', 'hr' => 'Glavne kategorije', 'hu' => 'Fő kategóriák',
            'ja' => '主なカテゴリー', 'ko' => '주요 카테고리', 'lt' => 'Pagrindinės kategorijos', 'nn' => 'Hovudkategoriar',
            'pl' => 'Główne kategorie', 'ro' => 'Categorii principale', 'ru' => 'Основные категории', 'sk' => 'Hlavné kategórie',
            'sl' => 'Glavne kategorije', 'sq' => 'Kategoritë kryesore', 'sr' => 'Главне категорије', 'sv' => 'Huvudkategorier',
            'tr' => 'Ana Kategoriler', 'uk' => 'Основні категорії', 'zh' => '主要类别',
        ],
        'promote' => [
            'en' => 'Promote', 'nl' => 'Promoten', 'de' => 'Bewerben', 'fr' => 'Promouvoir',
            'es' => 'Promocionar', 'it' => 'Promuovi', 'pt' => 'Promover', 'ar' => 'ترويج',
            'bg' => 'Промотирай', 'bs' => 'Promoviši', 'cs' => 'Propagovat', 'da' => 'Promover',
            'el' => 'Προώθηση', 'fi' => 'Mainosta', 'hr' => 'Promoviraj', 'hu' => 'Népszerűsítés',
            'ja' => 'プロモート', 'ko' => '홍보하기', 'lt' => 'Reklamuoti', 'nn' => 'Promover',
            'pl' => 'Promuj', 'ro' => 'Promovează', 'ru' => 'Продвигать', 'sk' => 'Propagovať',
            'sl' => 'Promoviraj', 'sq' => 'Promovo', 'sr' => 'Промовиши', 'sv' => 'Marknadsför',
            'tr' => 'Öne çıkar', 'uk' => 'Просувати', 'zh' => '推广',
        ],
        'contact_seller' => [
            'en' => 'Contact Seller', 'nl' => 'Contact verkoper', 'de' => 'Verkäufer kontaktieren', 'fr' => 'Contacter le vendeur',
            'es' => 'Contactar al vendedor', 'it' => 'Contatta il venditore', 'pt' => 'Contactar vendedor', 'ar' => 'تواصل مع البائع',
            'bg' => 'Свържете се с продавача', 'bs' => 'Kontaktiraj prodavca', 'cs' => 'Kontaktovat prodejce', 'da' => 'Kontakt sælger',
            'el' => 'Επικοινωνία με τον πωλητή', 'fi' => 'Ota yhteyttä myyjään', 'hr' => 'Kontaktiraj prodavača', 'hu' => 'Eladó kapcsolatfelvétel',
            'ja' => '出品者に連絡', 'ko' => '판매자에게 문의', 'lt' => 'Susisiekti su pardavėju', 'nn' => 'Kontakt seljar',
            'pl' => 'Skontaktuj się ze sprzedawcą', 'ro' => 'Contactează vânzătorul', 'ru' => 'Связаться с продавцом', 'sk' => 'Kontaktovať predajcu',
            'sl' => 'Kontaktiraj prodajalca', 'sq' => 'Kontakto shitësin', 'sr' => 'Контактирај продавца', 'sv' => 'Kontakta säljaren',
            'tr' => 'Satıcıyla iletişime geç', 'uk' => "Зв'язатися з продавцем", 'zh' => '联系卖家',
        ],
        'view_profile' => [
            'en' => 'View Profile', 'nl' => 'Profiel bekijken', 'de' => 'Profil ansehen', 'fr' => 'Voir le profil',
            'es' => 'Ver perfil', 'it' => 'Visualizza profilo', 'pt' => 'Ver perfil', 'ar' => 'عرض الملف الشخصي',
            'bg' => 'Виж профила', 'bs' => 'Pogledaj profil', 'cs' => 'Zobrazit profil', 'da' => 'Se profil',
            'el' => 'Προβολή προφίλ', 'fi' => 'Näytä profiili', 'hr' => 'Pogledaj profil', 'hu' => 'Profil megtekintése',
            'ja' => 'プロフィールを見る', 'ko' => '프로필 보기', 'lt' => 'Peržiūrėti profilį', 'nn' => 'Vis profil',
            'pl' => 'Zobacz profil', 'ro' => 'Vezi profilul', 'ru' => 'Посмотреть профиль', 'sk' => 'Zobraziť profil',
            'sl' => 'Ogled profila', 'sq' => 'Shiko profilin', 'sr' => 'Погледај профил', 'sv' => 'Visa profil',
            'tr' => 'Profili görüntüle', 'uk' => 'Переглянути профіль', 'zh' => '查看资料',
        ],
        'related_ads' => [
            'en' => 'Related Ads', 'nl' => 'Gerelateerde advertenties', 'de' => 'Ähnliche Anzeigen', 'fr' => 'Annonces similaires',
            'es' => 'Anuncios relacionados', 'it' => 'Annunci correlati', 'pt' => 'Anúncios relacionados', 'ar' => 'إعلانات ذات صلة',
            'bg' => 'Свързани обяви', 'bs' => 'Povezani oglasi', 'cs' => 'Související inzeráty', 'da' => 'Relaterede annoncer',
            'el' => 'Σχετικές αγγελίες', 'fi' => 'Aiheeseen liittyvät ilmoitukset', 'hr' => 'Povezani oglasi', 'hu' => 'Kapcsolódó hirdetések',
            'ja' => '関連する広告', 'ko' => '관련 광고', 'lt' => 'Susiję skelbimai', 'nn' => 'Relaterte annonsar',
            'pl' => 'Powiązane ogłoszenia', 'ro' => 'Anunțuri similare', 'ru' => 'Похожие объявления', 'sk' => 'Súvisiace inzeráty',
            'sl' => 'Povezani oglasi', 'sq' => 'Njoftime të ngjashme', 'sr' => 'Повезани огласи', 'sv' => 'Relaterade annonser',
            'tr' => 'İlgili ilanlar', 'uk' => 'Схожі оголошення', 'zh' => '相关广告',
        ],
        'search_by_distance' => [
            'en' => 'Search by distance', 'nl' => 'Zoeken op afstand', 'de' => 'Nach Entfernung suchen', 'fr' => 'Rechercher par distance',
            'es' => 'Buscar por distancia', 'it' => 'Cerca per distanza', 'pt' => 'Pesquisar por distância', 'ar' => 'البحث حسب المسافة',
            'bg' => 'Търсене по разстояние', 'bs' => 'Pretraga po udaljenosti', 'cs' => 'Hledat podle vzdálenosti', 'da' => 'Søg efter afstand',
            'el' => 'Αναζήτηση κατά απόσταση', 'fi' => 'Hae etäisyyden mukaan', 'hr' => 'Pretraga po udaljenosti', 'hu' => 'Keresés távolság szerint',
            'ja' => '距離で検索', 'ko' => '거리로 검색', 'lt' => 'Ieškoti pagal atstumą', 'nn' => 'Søk etter avstand',
            'pl' => 'Szukaj według odległości', 'ro' => 'Caută după distanță', 'ru' => 'Поиск по расстоянию', 'sk' => 'Hľadať podľa vzdialenosti',
            'sl' => 'Iskanje po razdalji', 'sq' => 'Kërko sipas distancës', 'sr' => 'Претрага по удаљености', 'sv' => 'Sök efter avstånd',
            'tr' => 'Mesafeye göre ara', 'uk' => 'Пошук за відстанню', 'zh' => '按距离搜索',
        ],
        'no_results_found' => [
            'en' => 'No results found', 'nl' => 'Geen resultaten gevonden', 'de' => 'Keine Ergebnisse gefunden', 'fr' => 'Aucun résultat trouvé',
            'es' => 'No se encontraron resultados', 'it' => 'Nessun risultato trovato', 'pt' => 'Nenhum resultado encontrado', 'ar' => 'لا توجد نتائج',
            'bg' => 'Няма намерени резултати', 'bs' => 'Nema rezultata', 'cs' => 'Nebyly nalezeny žádné výsledky', 'da' => 'Ingen resultater fundet',
            'el' => 'Δεν βρέθηκαν αποτελέσματα', 'fi' => 'Ei tuloksia', 'hr' => 'Nema pronađenih rezultata', 'hu' => 'Nincs találat',
            'ja' => '結果が見つかりません', 'ko' => '결과를 찾을 수 없습니다', 'lt' => 'Rezultatų nerasta', 'nn' => 'Ingen resultat funne',
            'pl' => 'Nie znaleziono wyników', 'ro' => 'Nu s-au găsit rezultate', 'ru' => 'Ничего не найдено', 'sk' => 'Nenašli sa žiadne výsledky',
            'sl' => 'Ni najdenih rezultatov', 'sq' => 'Nuk u gjetën rezultate', 'sr' => 'Нема резултата', 'sv' => 'Inga resultat hittades',
            'tr' => 'Sonuç bulunamadı', 'uk' => 'Нічого не знайдено', 'zh' => '未找到结果',
        ],
        'please_try_again' => [
            'en' => 'Please try again', 'nl' => 'Probeer het opnieuw', 'de' => 'Bitte versuchen Sie es erneut', 'fr' => 'Veuillez réessayer',
            'es' => 'Por favor, inténtalo de nuevo', 'it' => 'Riprova', 'pt' => 'Por favor, tente novamente', 'ar' => 'يرجى المحاولة مرة أخرى',
            'bg' => 'Моля, опитайте отново', 'bs' => 'Molimo pokušajte ponovo', 'cs' => 'Zkuste to prosím znovu', 'da' => 'Prøv venligst igen',
            'el' => 'Παρακαλώ δοκιμάστε ξανά', 'fi' => 'Yritä uudelleen', 'hr' => 'Molimo pokušajte ponovno', 'hu' => 'Kérjük, próbálja újra',
            'ja' => 'もう一度お試しください', 'ko' => '다시 시도해 주세요', 'lt' => 'Bandykite dar kartą', 'nn' => 'Prøv igjen',
            'pl' => 'Spróbuj ponownie', 'ro' => 'Vă rugăm încercați din nou', 'ru' => 'Пожалуйста, попробуйте снова', 'sk' => 'Skúste to znova',
            'sl' => 'Poskusite znova', 'sq' => 'Ju lutemi provoni përsëri', 'sr' => 'Молимо покушајте поново', 'sv' => 'Försök igen',
            'tr' => 'Lütfen tekrar deneyin', 'uk' => 'Будь ласка, спробуйте ще раз', 'zh' => '请重试',
        ],
        'retry' => [
            'en' => 'Retry', 'nl' => 'Opnieuw proberen', 'de' => 'Erneut versuchen', 'fr' => 'Réessayer',
            'es' => 'Reintentar', 'it' => 'Riprova', 'pt' => 'Tentar novamente', 'ar' => 'إعادة المحاولة',
            'bg' => 'Опитай отново', 'bs' => 'Pokušaj ponovo', 'cs' => 'Zkusit znovu', 'da' => 'Prøv igen',
            'el' => 'Επανάληψη', 'fi' => 'Yritä uudelleen', 'hr' => 'Pokušaj ponovno', 'hu' => 'Újra',
            'ja' => '再試行', 'ko' => '다시 시도', 'lt' => 'Bandyti dar kartą', 'nn' => 'Prøv igjen',
            'pl' => 'Ponów', 'ro' => 'Reîncearcă', 'ru' => 'Повторить', 'sk' => 'Skúsiť znova',
            'sl' => 'Poskusi znova', 'sq' => 'Provo përsëri', 'sr' => 'Покушај поново', 'sv' => 'Försök igen',
            'tr' => 'Tekrar dene', 'uk' => 'Повторити', 'zh' => '重试',
        ],
        'or' => [
            'en' => 'or', 'nl' => 'of', 'de' => 'oder', 'fr' => 'ou',
            'es' => 'o', 'it' => 'o', 'pt' => 'ou', 'ar' => 'أو',
            'bg' => 'или', 'bs' => 'ili', 'cs' => 'nebo', 'da' => 'eller',
            'el' => 'ή', 'fi' => 'tai', 'hr' => 'ili', 'hu' => 'vagy',
            'ja' => 'または', 'ko' => '또는', 'lt' => 'arba', 'nn' => 'eller',
            'pl' => 'lub', 'ro' => 'sau', 'ru' => 'или', 'sk' => 'alebo',
            'sl' => 'ali', 'sq' => 'ose', 'sr' => 'или', 'sv' => 'eller',
            'tr' => 'veya', 'uk' => 'або', 'zh' => '或',
        ],
        'condition' => [
            'en' => 'Condition', 'nl' => 'Staat', 'de' => 'Zustand', 'fr' => 'État',
            'es' => 'Estado', 'it' => 'Condizione', 'pt' => 'Condição', 'ar' => 'الحالة',
            'bg' => 'Състояние', 'bs' => 'Stanje', 'cs' => 'Stav', 'da' => 'Stand',
            'el' => 'Κατάσταση', 'fi' => 'Kunto', 'hr' => 'Stanje', 'hu' => 'Állapot',
            'ja' => '状態', 'ko' => '상태', 'lt' => 'Būklė', 'nn' => 'Tilstand',
            'pl' => 'Stan', 'ro' => 'Stare', 'ru' => 'Состояние', 'sk' => 'Stav',
            'sl' => 'Stanje', 'sq' => 'Gjendja', 'sr' => 'Стање', 'sv' => 'Skick',
            'tr' => 'Durum', 'uk' => 'Стан', 'zh' => '状况',
        ],
        'options' => [
            'en' => 'Options', 'nl' => 'Opties', 'de' => 'Optionen', 'fr' => 'Options',
            'es' => 'Opciones', 'it' => 'Opzioni', 'pt' => 'Opções', 'ar' => 'خيارات',
            'bg' => 'Опции', 'bs' => 'Opcije', 'cs' => 'Možnosti', 'da' => 'Indstillinger',
            'el' => 'Επιλογές', 'fi' => 'Vaihtoehdot', 'hr' => 'Opcije', 'hu' => 'Beállítások',
            'ja' => 'オプション', 'ko' => '옵션', 'lt' => 'Parinktys', 'nn' => 'Alternativ',
            'pl' => 'Opcje', 'ro' => 'Opțiuni', 'ru' => 'Опции', 'sk' => 'Možnosti',
            'sl' => 'Možnosti', 'sq' => 'Opsionet', 'sr' => 'Опције', 'sv' => 'Alternativ',
            'tr' => 'Seçenekler', 'uk' => 'Опції', 'zh' => '选项',
        ],
        'personal' => [
            'en' => 'Personal', 'nl' => 'Persoonlijk', 'de' => 'Persönlich', 'fr' => 'Personnel',
            'es' => 'Personal', 'it' => 'Personale', 'pt' => 'Pessoal', 'ar' => 'شخصي',
            'bg' => 'Личен', 'bs' => 'Lično', 'cs' => 'Osobní', 'da' => 'Personlig',
            'el' => 'Προσωπικό', 'fi' => 'Henkilökohtainen', 'hr' => 'Osobno', 'hu' => 'Személyes',
            'ja' => '個人', 'ko' => '개인', 'lt' => 'Asmeninis', 'nn' => 'Personleg',
            'pl' => 'Osobiste', 'ro' => 'Personal', 'ru' => 'Личный', 'sk' => 'Osobné',
            'sl' => 'Osebno', 'sq' => 'Personale', 'sr' => 'Лично', 'sv' => 'Personlig',
            'tr' => 'Kişisel', 'uk' => 'Особистий', 'zh' => '个人',
        ],
        'business_account' => [
            'en' => 'Business Account', 'nl' => 'Zakelijk account', 'de' => 'Geschäftskonto', 'fr' => 'Compte professionnel',
            'es' => 'Cuenta de empresa', 'it' => 'Account aziendale', 'pt' => 'Conta empresarial', 'ar' => 'حساب تجاري',
            'bg' => 'Бизнес акаунт', 'bs' => 'Poslovni račun', 'cs' => 'Firemní účet', 'da' => 'Erhvervskonto',
            'el' => 'Επαγγελματικός λογαριασμός', 'fi' => 'Yritystili', 'hr' => 'Poslovni račun', 'hu' => 'Üzleti fiók',
            'ja' => 'ビジネスアカウント', 'ko' => '비즈니스 계정', 'lt' => 'Verslo paskyra', 'nn' => 'Bedriftskonto',
            'pl' => 'Konto firmowe', 'ro' => 'Cont de afaceri', 'ru' => 'Бизнес-аккаунт', 'sk' => 'Firemný účet',
            'sl' => 'Poslovni račun', 'sq' => 'Llogari biznesi', 'sr' => 'Пословни налог', 'sv' => 'Företagskonto',
            'tr' => 'İşletme hesabı', 'uk' => 'Бізнес-акаунт', 'zh' => '企业账户',
        ],
        'private_account' => [
            'en' => 'Private Account', 'nl' => 'Privéaccount', 'de' => 'Privatkonto', 'fr' => 'Compte privé',
            'es' => 'Cuenta privada', 'it' => 'Account privato', 'pt' => 'Conta privada', 'ar' => 'حساب خاص',
            'bg' => 'Личен акаунт', 'bs' => 'Privatni račun', 'cs' => 'Soukromý účet', 'da' => 'Privat konto',
            'el' => 'Προσωπικός λογαριασμός', 'fi' => 'Yksityinen tili', 'hr' => 'Privatni račun', 'hu' => 'Magánfiók',
            'ja' => '個人アカウント', 'ko' => '개인 계정', 'lt' => 'Privati paskyra', 'nn' => 'Privat konto',
            'pl' => 'Konto prywatne', 'ro' => 'Cont privat', 'ru' => 'Личный аккаунт', 'sk' => 'Súkromný účet',
            'sl' => 'Zasebni račun', 'sq' => 'Llogari private', 'sr' => 'Приватни налог', 'sv' => 'Privat konto',
            'tr' => 'Bireysel hesap', 'uk' => 'Приватний акаунт', 'zh' => '个人账户',
        ],
        'by_distance' => [
            'en' => 'By distance', 'nl' => 'Op afstand', 'de' => 'Nach Entfernung', 'fr' => 'Par distance',
            'es' => 'Por distancia', 'it' => 'Per distanza', 'pt' => 'Por distância', 'ar' => 'حسب المسافة',
            'bg' => 'По разстояние', 'bs' => 'Po udaljenosti', 'cs' => 'Podle vzdálenosti', 'da' => 'Efter afstand',
            'el' => 'Κατά απόσταση', 'fi' => 'Etäisyyden mukaan', 'hr' => 'Po udaljenosti', 'hu' => 'Távolság szerint',
            'ja' => '距離順', 'ko' => '거리순', 'lt' => 'Pagal atstumą', 'nn' => 'Etter avstand',
            'pl' => 'Według odległości', 'ro' => 'După distanță', 'ru' => 'По расстоянию', 'sk' => 'Podľa vzdialenosti',
            'sl' => 'Po razdalji', 'sq' => 'Sipas distancës', 'sr' => 'По удаљености', 'sv' => 'Efter avstånd',
            'tr' => 'Mesafeye göre', 'uk' => 'За відстанню', 'zh' => '按距离',
        ],
        'distance_km' => [
            'en' => 'Distance (km)', 'nl' => 'Afstand (km)', 'de' => 'Entfernung (km)', 'fr' => 'Distance (km)',
            'es' => 'Distancia (km)', 'it' => 'Distanza (km)', 'pt' => 'Distância (km)', 'ar' => 'المسافة (كم)',
            'bg' => 'Разстояние (км)', 'bs' => 'Udaljenost (km)', 'cs' => 'Vzdálenost (km)', 'da' => 'Afstand (km)',
            'el' => 'Απόσταση (χλμ)', 'fi' => 'Etäisyys (km)', 'hr' => 'Udaljenost (km)', 'hu' => 'Távolság (km)',
            'ja' => '距離（km）', 'ko' => '거리(km)', 'lt' => 'Atstumas (km)', 'nn' => 'Avstand (km)',
            'pl' => 'Odległość (km)', 'ro' => 'Distanță (km)', 'ru' => 'Расстояние (км)', 'sk' => 'Vzdialenosť (km)',
            'sl' => 'Razdalja (km)', 'sq' => 'Distanca (km)', 'sr' => 'Удаљеност (km)', 'sv' => 'Avstånd (km)',
            'tr' => 'Mesafe (km)', 'uk' => 'Відстань (км)', 'zh' => '距离（公里）',
        ],
        'battery_information' => [
            'en' => 'Battery information', 'nl' => 'Accu-informatie', 'de' => 'Batterieinformationen', 'fr' => 'Informations sur la batterie',
            'es' => 'Información de la batería', 'it' => 'Informazioni sulla batteria', 'pt' => 'Informações da bateria', 'ar' => 'معلومات البطارية',
            'bg' => 'Информация за батерията', 'bs' => 'Informacije o bateriji', 'cs' => 'Informace o baterii', 'da' => 'Batteriinformation',
            'el' => 'Πληροφορίες μπαταρίας', 'fi' => 'Akun tiedot', 'hr' => 'Informacije o bateriji', 'hu' => 'Akkumulátor-információk',
            'ja' => 'バッテリー情報', 'ko' => '배터리 정보', 'lt' => 'Baterijos informacija', 'nn' => 'Batteriinformasjon',
            'pl' => 'Informacje o baterii', 'ro' => 'Informații despre baterie', 'ru' => 'Информация об аккумуляторе', 'sk' => 'Informácie o batérii',
            'sl' => 'Informacije o bateriji', 'sq' => 'Informacione për baterinë', 'sr' => 'Информације о батерији', 'sv' => 'Batteriinformation',
            'tr' => 'Batarya bilgisi', 'uk' => 'Інформація про акумулятор', 'zh' => '电池信息',
        ],
        'environmental_details' => [
            'en' => 'Environmental details', 'nl' => 'Milieudetails', 'de' => 'Umweltdetails', 'fr' => 'Détails environnementaux',
            'es' => 'Detalles ambientales', 'it' => 'Dettagli ambientali', 'pt' => 'Detalhes ambientais', 'ar' => 'التفاصيل البيئية',
            'bg' => 'Екологични детайли', 'bs' => 'Ekološki detalji', 'cs' => 'Ekologické údaje', 'da' => 'Miljødetaljer',
            'el' => 'Περιβαλλοντικά στοιχεία', 'fi' => 'Ympäristötiedot', 'hr' => 'Ekološki detalji', 'hu' => 'Környezeti adatok',
            'ja' => '環境情報', 'ko' => '환경 정보', 'lt' => 'Aplinkosaugos informacija', 'nn' => 'Miljødetaljar',
            'pl' => 'Szczegóły środowiskowe', 'ro' => 'Detalii de mediu', 'ru' => 'Экологические данные', 'sk' => 'Ekologické údaje',
            'sl' => 'Okoljski podatki', 'sq' => 'Detajet mjedisore', 'sr' => 'Еколошки детаљи', 'sv' => 'Miljödetaljer',
            'tr' => 'Çevre bilgileri', 'uk' => 'Екологічні дані', 'zh' => '环境详情',
        ],
        'i_agree_terms' => [
            'en' => 'I agree to the Terms and Privacy policy', 'nl' => 'Ik ga akkoord met de Voorwaarden en het Privacybeleid',
            'de' => 'Ich stimme den AGB und der Datenschutzrichtlinie zu', 'fr' => "J'accepte les Conditions et la Politique de confidentialité",
            'es' => 'Acepto los Términos y la Política de privacidad', 'it' => "Accetto i Termini e l'Informativa sulla privacy",
            'pt' => 'Aceito os Termos e a Política de Privacidade', 'ar' => 'أوافق على الشروط وسياسة الخصوصية',
            'bg' => 'Съгласявам се с Условията и Политиката за поверителност', 'bs' => 'Slažem se s Uvjetima i Pravilima privatnosti',
            'cs' => 'Souhlasím s podmínkami a zásadami ochrany osobních údajů', 'da' => 'Jeg accepterer vilkårene og privatlivspolitikken',
            'el' => 'Συμφωνώ με τους Όρους και την Πολιτική Απορρήτου', 'fi' => 'Hyväksyn käyttöehdot ja tietosuojakäytännön',
            'hr' => 'Slažem se s Uvjetima i Pravilima o privatnosti', 'hu' => 'Elfogadom a Feltételeket és az Adatvédelmi irányelvet',
            'ja' => '利用規約とプライバシーポリシーに同意します', 'ko' => '이용약관 및 개인정보 처리방침에 동의합니다',
            'lt' => 'Sutinku su sąlygomis ir privatumo politika', 'nn' => 'Eg godtek vilkåra og personvernreglane',
            'pl' => 'Akceptuję Regulamin i Politykę prywatności', 'ro' => 'Sunt de acord cu Termenii și Politica de confidențialitate',
            'ru' => 'Я принимаю Условия и Политику конфиденциальности', 'sk' => 'Súhlasím s podmienkami a zásadami ochrany osobných údajov',
            'sl' => 'Strinjam se s Pogoji in Politiko zasebnosti', 'sq' => 'Pajtohem me Kushtet dhe Politikën e privatësisë',
            'sr' => 'Слажем се са Условима и Политиком приватности', 'sv' => 'Jag godkänner villkoren och integritetspolicyn',
            'tr' => 'Şartları ve Gizlilik Politikasını kabul ediyorum', 'uk' => 'Я погоджуюся з Умовами та Політикою конфіденційності',
            'zh' => '我同意条款和隐私政策',
        ],
        'joined_today' => [
            'en' => 'Joined today', 'nl' => 'Vandaag lid geworden', 'de' => 'Heute beigetreten', 'fr' => "Inscrit aujourd'hui",
            'es' => 'Se unió hoy', 'it' => 'Iscritto oggi', 'pt' => 'Entrou hoje', 'ar' => 'انضم اليوم',
            'bg' => 'Присъедини се днес', 'bs' => 'Pridružio se danas', 'cs' => 'Připojil se dnes', 'da' => 'Tilmeldt i dag',
            'el' => 'Εγγράφηκε σήμερα', 'fi' => 'Liittyi tänään', 'hr' => 'Pridružio se danas', 'hu' => 'Ma csatlakozott',
            'ja' => '本日登録', 'ko' => '오늘 가입', 'lt' => 'Prisijungė šiandien', 'nn' => 'Vart medlem i dag',
            'pl' => 'Dołączył dzisiaj', 'ro' => 'S-a alăturat astăzi', 'ru' => 'Присоединился сегодня', 'sk' => 'Pridal sa dnes',
            'sl' => 'Pridružil se danes', 'sq' => 'U bashkua sot', 'sr' => 'Придружио се данас', 'sv' => 'Gick med idag',
            'tr' => 'Bugün katıldı', 'uk' => 'Приєднався сьогодні', 'zh' => '今天加入',
        ],
        'day_ago' => [
            'en' => 'day ago', 'nl' => 'dag geleden', 'de' => 'Tag her', 'fr' => 'jour',
            'es' => 'día atrás', 'it' => 'giorno fa', 'pt' => 'dia atrás', 'ar' => 'يوم مضى',
            'bg' => 'ден по-рано', 'bs' => 'dan prije', 'cs' => 'dnem', 'da' => 'dag siden',
            'el' => 'μέρα πριν', 'fi' => 'päivä sitten', 'hr' => 'dan prije', 'hu' => 'napja',
            'ja' => '日前', 'ko' => '일 전', 'lt' => 'diena prieš', 'nn' => 'dag sidan',
            'pl' => 'dzień temu', 'ro' => 'zi în urmă', 'ru' => 'день назад', 'sk' => 'dňom',
            'sl' => 'dan nazaj', 'sq' => 'ditë më parë', 'sr' => 'дан пре', 'sv' => 'dag sedan',
            'tr' => 'gün önce', 'uk' => 'день тому', 'zh' => '天前',
        ],
        'days_ago' => [
            'en' => 'days ago', 'nl' => 'dagen geleden', 'de' => 'Tage her', 'fr' => 'jours',
            'es' => 'días atrás', 'it' => 'giorni fa', 'pt' => 'dias atrás', 'ar' => 'أيام مضت',
            'bg' => 'дни по-рано', 'bs' => 'dana prije', 'cs' => 'dny', 'da' => 'dage siden',
            'el' => 'μέρες πριν', 'fi' => 'päivää sitten', 'hr' => 'dana prije', 'hu' => 'napja',
            'ja' => '日前', 'ko' => '일 전', 'lt' => 'dienų prieš', 'nn' => 'dagar sidan',
            'pl' => 'dni temu', 'ro' => 'zile în urmă', 'ru' => 'дней назад', 'sk' => 'dňami',
            'sl' => 'dni nazaj', 'sq' => 'ditë më parë', 'sr' => 'дана пре', 'sv' => 'dagar sedan',
            'tr' => 'gün önce', 'uk' => 'днів тому', 'zh' => '天前',
        ],
        'months_ago' => [
            'en' => 'months ago', 'nl' => 'maanden geleden', 'de' => 'Monate her', 'fr' => 'mois',
            'es' => 'meses atrás', 'it' => 'mesi fa', 'pt' => 'meses atrás', 'ar' => 'أشهر مضت',
            'bg' => 'месеца по-рано', 'bs' => 'mjeseci prije', 'cs' => 'měsíci', 'da' => 'måneder siden',
            'el' => 'μήνες πριν', 'fi' => 'kuukautta sitten', 'hr' => 'mjeseci prije', 'hu' => 'hónapja',
            'ja' => 'ヶ月前', 'ko' => '개월 전', 'lt' => 'mėnesių prieš', 'nn' => 'månader sidan',
            'pl' => 'miesięcy temu', 'ro' => 'luni în urmă', 'ru' => 'месяцев назад', 'sk' => 'mesiacmi',
            'sl' => 'mesecev nazaj', 'sq' => 'muaj më parë', 'sr' => 'месеци пре', 'sv' => 'månader sedan',
            'tr' => 'ay önce', 'uk' => 'місяців тому', 'zh' => '个月前',
        ],
        'years_ago' => [
            'en' => 'years ago', 'nl' => 'jaar geleden', 'de' => 'Jahre her', 'fr' => 'ans',
            'es' => 'años atrás', 'it' => 'anni fa', 'pt' => 'anos atrás', 'ar' => 'سنوات مضت',
            'bg' => 'години по-рано', 'bs' => 'godina prije', 'cs' => 'lety', 'da' => 'år siden',
            'el' => 'χρόνια πριν', 'fi' => 'vuotta sitten', 'hr' => 'godina prije', 'hu' => 'éve',
            'ja' => '年前', 'ko' => '년 전', 'lt' => 'metų prieš', 'nn' => 'år sidan',
            'pl' => 'lat temu', 'ro' => 'ani în urmă', 'ru' => 'лет назад', 'sk' => 'rokmi',
            'sl' => 'let nazaj', 'sq' => 'vite më parë', 'sr' => 'година пре', 'sv' => 'år sedan',
            'tr' => 'yıl önce', 'uk' => 'років тому', 'zh' => '年前',
        ],
        'n_a' => [
            'en' => '—', 'nl' => '—', 'de' => '—', 'fr' => '—', 'es' => '—', 'it' => '—', 'pt' => '—', 'ar' => '—',
            'bg' => '—', 'bs' => '—', 'cs' => '—', 'da' => '—', 'el' => '—', 'fi' => '—', 'hr' => '—', 'hu' => '—',
            'ja' => '—', 'ko' => '—', 'lt' => '—', 'nn' => '—', 'pl' => '—', 'ro' => '—', 'ru' => '—', 'sk' => '—',
            'sl' => '—', 'sq' => '—', 'sr' => '—', 'sv' => '—', 'tr' => '—', 'uk' => '—', 'zh' => '—',
        ],
        // Dedicated nav-tab label — the website's shared 'profile' key means
        // "Seller Profile", so the app tab uses its own key for plain "Profile".
        'profile_tab' => [
            'en' => 'Profile', 'nl' => 'Profiel', 'de' => 'Profil', 'fr' => 'Profil',
            'es' => 'Perfil', 'it' => 'Profilo', 'pt' => 'Perfil', 'ar' => 'الملف الشخصي',
            'bg' => 'Профил', 'bs' => 'Profil', 'cs' => 'Profil', 'da' => 'Profil',
            'el' => 'Προφίλ', 'fi' => 'Profiili', 'hr' => 'Profil', 'hu' => 'Profil',
            'ja' => 'プロフィール', 'ko' => '프로필', 'lt' => 'Profilis', 'nn' => 'Profil',
            'pl' => 'Profil', 'ro' => 'Profil', 'ru' => 'Профиль', 'sk' => 'Profil',
            'sl' => 'Profil', 'sq' => 'Profili', 'sr' => 'Профил', 'sv' => 'Profil',
            'tr' => 'Profil', 'uk' => 'Профіль', 'zh' => '个人资料',
        ],
    ];

    /** app key => existing website key whose values (all locales) to reuse verbatim. */
    private array $copyFrom = [
        'something_went_wrong'  => 'Something went wrong!',
        'more_from_this_seller' => 'more_from_the_store',
        'transmission'          => 'transmission_type',
        'results'               => 'result',
        'make_offer'            => 'make_an_offer',
    ];

    public function run(): void
    {
        $locales = [];

        foreach ($this->authored as $key => $byLocale) {
            foreach ($byLocale as $locale => $value) {
                LanguageTranslation::updateOrCreate(
                    ['locale' => $locale, 'key' => $key],
                    ['value' => $value],
                );
                $locales[$locale] = true;
            }
        }

        foreach ($this->copyFrom as $key => $sourceKey) {
            $rows = LanguageTranslation::where('key', $sourceKey)
                ->whereNotNull('value')->where('value', '!=', '')
                ->pluck('value', 'locale');
            foreach ($rows as $locale => $value) {
                LanguageTranslation::updateOrCreate(
                    ['locale' => $locale, 'key' => $key],
                    ['value' => $value],
                );
                $locales[$locale] = true;
            }
        }

        // Bust the per-locale translation caches so LocaleController serves the
        // new strings immediately (it caches translations_{locale} forever).
        foreach (array_keys($locales) as $locale) {
            Cache::store('file')->forget("translations_{$locale}");
            Cache::forget("translations_version_{$locale}");
        }

        $this->command?->info('Seeded '.(count($this->authored) + count($this->copyFrom)).' app translation keys across '.count($locales).' locales.');
    }
}
