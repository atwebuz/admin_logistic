## Tasks
ratings ball, timer, status, notification, report, monitoring, pdf checker, log

___
1) login, register dizayn berish kere +++

2) order table da finish btn yonida yana 2 ta btn (BOL and note for driver) (event qo'shiladi) 

0)  track table: id, name, number, timezone +++

1) BOL -> document edit ... ?

2) categoryda blade da company driver qoshish kere +++

3) interactive timer -> timer kottaro qlish kere

4) driver registrationda (Company, ismi, track, timezone, description) agar driver description edit boladigan bosa 1 xafta block bolishi kere ++++

5) emloyee task (order) oganda o'zgaradi (Company, ismi , track, timezone, description) tegida zaproz bergandi opisanya qolishi kere

6) manager->satrudniki da 2 ta status bo'lishi kere 1-online , 2-working ken 

7) qaysi employer taskni oganinyam chqazsh kere va xammasi details da bo'lishi kere km oldi qachon oldi etc... ++++

8) Manage sidebar(Category, compnay, driver) compact ++++

9)   manager -> employerlani statistikasini ko'rishi kere qachon task ogan nma qgan, shtraf etc...1oyli,1yilli

10) employer 5 oy ishladi ken atchot topshrmoqchi nechta zakaz nechi ball qaysi driverga qaysi voqtda 300 ball yegdim 20 ball shtraf etc...

11) sidebar: Monitoring (compnay driver, task, timezone)

12) satrudnikida monitoring qlish kere manager blan admin (emp name, company, driver, qancha voqt qoldi, comment yozish) 
va call button qo'yish kere bosganda usha employerni chaqirishi kere for example: alert("sizni admin chaqrvotti ") 

1)  orderni redaktirovat qlolshi kere: for example: emp qyn task ob qoydi va manager uni taskini boshqa emp ga berolshi kere

2)  task timer tugavotti redaktirovat qlib extra time qo'shish kere va exrta time editable bo'lishi kere

3)  emp ga shtraf berolishi kere, misolchun 20 minut kech qoldi va bu reportga tushushi kere shu masala bo'yicha shtraf oldi db

4)  finish btn bosganda ball oldin ertasiga check bo'voganda xato bo'sa minus ball bo'lishi kere

5)  register, loginda -> register keremas faqat manager or admin user sazdat qlolishi kere ++++

## OLD
---
1) сотрудник узини балини и штрафини korishi кере 

2) вкладка Task заказ бор лкн, админ и менеджер Task вкладкасида запрос бериши керемас отдельный вкладкада бериши кере, бомасам каша болади 

3) запрос кеганида сотрудник кийин ортанча кийн или осонлигини билиши кере, менеджер админ бервотганда уровень сложности тоже бериши кере, сотрудник определить килиши учун цвет ишлатиш кере и порядок болиш кере, Пример сложный запрос высвечивается красным и стоит самом верху, если легкий то самом низу 

5) Регистрациядан отганидан кеин унга роль берсаям бомади, к тому же автоматически роль берганда сразу Permissions берсин шунга яраша 

6) картинка алмашади логода 

11) рейтинг вкладка факат админ кориши кере хамма сотрудниклани, а обычный сотрудникда место рейтинг вкладка, вкладкани номи daily и просто Ball и штраф кориши кере узиникини

12) таймер нотори ишлавоти 19:1 01:1 корсатвоти 

13) код кориниб коган рейтинг вкладкасида 

14) кнопка offline босганда online боп турипти лкн refresh киворса сайтни кайтиб ковоти offline 

15) кнопкани босганда онлайн боганда админ и менеджер коRolesдими шу момент бор корсатмади, агар Employee вкладкасида боса там хар доим employee онлайн турипти бошка одамла йо хотя регистрацияда отганди тест учун

16) запрос берганда енги сотрудник билмасдан кийнини олиб койди, редактировать килолши кере админ или менеджер чтобы более опытный сотрудник килиши учун, и таймер суриб бериш кере болади потому что пока бошка одам огунича вакт кетиб колади и штраф олади бошка оган одам

18) запрос бервотганда админ или менеджер канча вактда килиш керелиги шотта баг боган 20 минут стандарт хотя бирхил нарсалага 5 минут или 1 соат кере болади
___
## Qlib bo'lingan
4) Control пользователями обычный сотрудник очолмасин скрыть боп турвурсин (auth->user->name != 'Employee') +++
w
7) Document вкладкасида ушата турган нарсалани скачать килиш возможности босин, скачать бомади < download></> +++

8) Employee вкладкасида факат employee турипти хотя регистрациядан отказиб корди тест килиб уша вкладкада чикмади if(auth->user->name == 'Employee') +++

9) обычный сотрудникда, Employee вкладкаси болиши керемас бекитилсин +++

10) кеин почти хамма жойда id по порядку кетвоти, пример запрос 1 и айди 1, кеин яна 10 запрос берди хаммаси по порядку кетди, мисол учун 5 килди и ула удалиться килинишди кеин яна 20 запрос кошди кеинги 20 запросни айдиси 30 гача боради шуниям fix килиш кере {{ $loop->iteration }} +++ 

17) катта список ишлатиган боса айди багини fix килиш кере {{ $loop->iteration }} +++ 

11) удалить босганда удалиться кNameпти и код чиквоти sql onDelete('cascade') +++

## Database
<p align="center"><img src="./.git/../github/db.png"></p>

<a align="center" style="display:flex;justify-content:center; background:black; padding:10px; border-radius:10px;" href="https://dbdiagram.io/d/6493408c02bd1c4a5edc032e">Link to db</a>
___

## About Template

This is ready admin panel template with
- [AdminLte V3](https://adminlte.io/themes/v3/)
- [Laravel 8](https://laravel.com/docs/8.x)
- [Laravel-permissions (Spatie.be)](https://spatie.be/docs/laravel-permission/v3/introduction)
- [Authorization laravel/ui](https://github.com/laravel/ui)

Laravel is accessible, powerful, and provides tools required for large, robust applications.
# Laravel 8 & AdminLte 3.0 & RBAC

## Login

                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' 'password',
             
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' 'password',
  
                'name' => 'Employee',
                'email' => 'employee@example.com',
                'password' 'password',
   