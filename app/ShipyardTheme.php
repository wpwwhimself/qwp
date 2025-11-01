<?php

namespace App;

use App\Theme\Shipyard\Theme;

class ShipyardTheme
{
    use Theme;

    #region theme
    /**
     * Available themes:
     * - origin - separated cells, clean background, contents floating in the middle
     * - austerity - broad background, main sections spread out
     */
    public const THEME = "future";
    #endregion

    #region colors
    /**
     * App accent colors:
     * - primary - for background, primary (disruptive) actions and important text
     * - secondary - for default buttons and links
     * - tertiary - for non-disruptive interactive elements
     */
    public const COLORS = [
        "primary" => "#17ecb0",
        "secondary" => "#1d9271",
        "tertiary" => "#2cbcff",
    ];
    #endregion

    #region fonts
    /**
     * type in the font declaration just as you would in a CSS file
     */
    public const FONTS = [
        "base" => ["Raleway", "sans-serif"],
        "heading" => ["Krona One", "sans-serif"],
        "mono" => ["Ubuntu Mono", "monospace"],
    ];

    // if fonts come from Google Fonts, add the URL here
    public const FONT_IMPORT_URL = 'https://fonts.googleapis.com/css2?family=Krona+One&family=Raleway:ital,wght@0,100..900;1,100..900&family=Ubuntu+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap';
    #endregion
}
