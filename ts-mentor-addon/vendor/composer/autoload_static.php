<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit73dba83455376f3e87cfb01282cb6ebd
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TS\\Base\\ModuleBase' => __DIR__ . '/../..' . '/includes/base/module-base.php',
        'TS\\Base\\Widget_Base' => __DIR__ . '/../..' . '/includes/base/widget-base.php',
        'TS\\Classes\\Dashboard' => __DIR__ . '/../..' . '/includes/classes/dashboard.php',
        'TS\\Classes\\Lazy_Query_Manager' => __DIR__ . '/../..' . '/includes/classes/lazy-query-manager.php',
        'TS\\Classes\\ModuleManager' => __DIR__ . '/../..' . '/includes/classes/module-manager.php',
        'TS\\Classes\\Pdf_Select_Manager' => __DIR__ . '/../..' . '/includes/classes/pdf-select-manager.php',
        'TS\\Classes\\QueryModule' => __DIR__ . '/../..' . '/includes/classes/query-module.php',
        'TS\\Classes\\TsSettings' => __DIR__ . '/../..' . '/includes/classes/settings.php',
        'TS\\Controls\\Lazy_Select' => __DIR__ . '/../..' . '/includes/controls/lazy-select.php',
        'TS\\Controls\\Pdf_Select' => __DIR__ . '/../..' . '/includes/controls/pdf-select.php',
        'TS\\Controls\\Select2' => __DIR__ . '/../..' . '/includes/controls/select2.php',
        'TS\\Controls\\TS_Query' => __DIR__ . '/../..' . '/includes/controls/ts-query.php',
        'TS\\Helper' => __DIR__ . '/../..' . '/includes/helper.php',
        'TS\\Modules\\Advancetabs\\Module' => __DIR__ . '/../..' . '/includes/modules/advancetabs/module.php',
        'TS\\Modules\\Advancetabs\\Widgets\\TsAdvTabs' => __DIR__ . '/../..' . '/includes/modules/advancetabs/widgets/ts-adv-tabs.php',
        'TS\\Modules\\Cpt\\Module' => __DIR__ . '/../..' . '/includes/modules/cpt/module.php',
        'TS\\Modules\\Cpt\\Widgets\\TsCpt' => __DIR__ . '/../..' . '/includes/modules/cpt/widgets/customposttype.php',
        'TS\\Modules\\Woocommerce\\Module' => __DIR__ . '/../..' . '/includes/modules/woocommerce/module.php',
        'TS\\Modules\\Woocommerce\\Widgets\\TsWooRpByCat' => __DIR__ . '/../..' . '/includes/modules/woocommerce/widgets/rp.php',
        'TS\\Modules\\Woocommerce\\Widgets\\TsWooTitle' => __DIR__ . '/../..' . '/includes/modules/woocommerce/widgets/ts-woo-title.php',
        'TS\\Plugin' => __DIR__ . '/../..' . '/includes/bootstrap.php',
        'TS\\Traits\\Ajax' => __DIR__ . '/../..' . '/includes/traits/ajax.php',
        'TS\\Traits\\Core' => __DIR__ . '/../..' . '/includes/traits/core.php',
        'TS\\Traits\\Enqueue' => __DIR__ . '/../..' . '/includes/traits/enqueue.php',
        'TS\\Traits\\Generator' => __DIR__ . '/../..' . '/includes/traits/generator.php',
        'TS\\Ts' => __DIR__ . '/../..' . '/includes/ts.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit73dba83455376f3e87cfb01282cb6ebd::$classMap;

        }, null, ClassLoader::class);
    }
}
