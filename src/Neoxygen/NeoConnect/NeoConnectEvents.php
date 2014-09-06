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
    /**
     * This Event is dipatched by the HttpClient before the request is created.
     * You have access to a custom Request object containing the method, url, body, and connection defaults properties
     *
     */
    const PRE_REQUEST_CREATE = 'pre.request_create';

    /**
     * This Event is dispatched before the Request is sent to the Neo4j DB
     * You receive a Neoxygen\NeoConnect\Event\PreRequestSendEvent containing the Request
     * that you can access with the $event->getRequest() method
     */
    const PRE_REQUEST_SEND = 'pre_request_send';

    /**
     * This Event is dispatched after the Request has been sent to the Neo4j DB
     * You receive a Neoxygen\NeoConnect\Event\PostRequestSendEvent containg the Response and also the start and
     * end microtimes before and after the request sending process.
     * that you can access with the $event->getResponse() , getStartTime(), getEndTime methods
     */
    const POST_REQUEST_SEND = 'post.request_send';

    /**
     * This Event is dispatched before a Query is added to the Stack.
     * This can be useful for e.g. adding resultDataContents parameters for a statement.
     * You have access to the statement that will be added to the stack by using the
     * $event->getStatement() method
     */
    const PRE_QUERY_ADD_TO_STACK = 'pre.query_add_to_stack';

    /**
     * This Event is dispatched before the statements are prepared for flush
     * The preparation of the statements consist of creating a valid array of statements for POST sending to the db
     * This array will be json encoded by a PreRequestCreateListener
     *
     * This event gives you access to the Stack of statements, $event->getStack()
     */
    const PRE_PREPARE_STATEMENTS_FOR_FLUSH = 'pre.prepare_statements_for_flush';

    /**
     * This Event is dispatch primarly for debug logging purposes and does not contain any objects.
     * This Event consists of a level, a message and an context array
     */
    const GENERIC_LOGGING = 'generic.logging';

    /**
     * This Event is dispatched when the commit strategy has determined that the queue should not be flushed
     * This Event return the Query Queue of the last sendQuery action
     */
    const QUEUE_SHOULD_NOT_BE_FLUSHED_EVENT = 'queue.should_not_be_flushed';

    /**
     * This Event is dispatched when the commit strategy has determined that the queue should be flushed
     * This Event return the Query Queue of the last sendQuery action
     */
    const QUEUE_SHOULD_BE_FLUSHED_EVENT = 'queue.should_be_flushed';
}
