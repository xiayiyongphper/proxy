<?php
/**
 * This file is part of the SysInfo package.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @link https://github.com/christeredvartsen/sysinfo
 */

namespace SysInfo;

/**
 * Uptime interface
 */
interface LoadInterface {
    /**
     * Get the load average
     *
     * First index: Avg. over the last minute
     * Second index: Avg. over the last 5 minutes
     * Third index: Avg. over the last 15 minutes
     *
     * @return double[]
     */
    function getAvg();
}
