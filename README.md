# SpigotTimingsPaste

A plugin to paste your timings to the [Spigot Timings](https://timings.spigotmc.org/) instead
of [PMMP Timings](https://timings.pmmp.io/).

For some unknown reason, the PMMP's timings does not accept non-ascii characters (or, non-utf8) and big timings data.

In this case you can use this plugin to paste your timings to the Spigot Timings.

## Warning: This plugin does not work as of PM 4.18

# Usage

1. Install the plugin
2. Run `/timings on` to start the timings.
3. Run `/timings paste` to paste the timings to Spigot Timings.
4. See results on provided link.

# How does it work?

Spigot decided to continue to use Timings v1 which is the exact same format as PMMP Timings.

So we can just post data to the Spigot Timings API, and it will work.
