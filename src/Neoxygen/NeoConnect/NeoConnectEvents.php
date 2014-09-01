<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Neoxygen\NeoConnect;

final class NeoConnectEvents
{
    const PRE_REQUEST_SEND = 'pre_request_send';

    const POST_REQUEST_SEND = 'post.request_send';

    const PRE_QUERY_ADD_TO_STACK = 'pre.query_add_to_stack';

    const PRE_PREPARE_STATEMENTS_FOR_FLUSH = 'pre.prepare_statements_for_flush';

    const GENERIC_LOGGING = 'generic.logging';
}
