# Rounded Chatbot UI

## Overview

A modern, rounded chatbot interface for the WordPress website. The chatbot is fixed to the right side of the viewport and positioned above the WhatsApp button.

## Design Goals

- Clean and minimal
- Fully rounded interface elements
- Smooth open and close interaction
- Compact but readable layout
- Premium, friendly chat-app experience

## Components

### Chat Toggle Button

- Circular floating button fixed on the right side
- Positioned above the WhatsApp button
- Contains a chat icon
- Uses a soft shadow for depth
- Clicking the button opens the chatbot
- Clicking it again closes the chatbot
- Hover state slightly enlarges the button

### Chat Window

- Medium-sized popup box positioned above the toggle button
- Rounded corners with soft edges
- White background
- Soft shadow and minimal borders
- Opens with a fade-in and slide-up animation
- Contains a header, messages area, and input area

### Header

- Rounded top corners
- Solid brand-color background
- Displays the bot name, such as `Support Assistant`
- Includes an optional close icon
- Should feel welcoming without being visually heavy

### Messages Area

- Scrollable message list
- Consistent spacing between messages
- Rounded message bubbles
- Bot messages are left aligned with a distinct light brand background
- User messages are right aligned with a light neutral background
- The interface may show a typing indicator before bot replies

### Input Area

- Rounded text input with a soft border or shadow
- Placeholder text: `Type your message...`
- Includes an optional send icon button
- Controls should have thumb-friendly spacing on mobile

## Visual Style

### Colors

- Primary: blue or the established website brand color
- Background: white
- Text: dark gray
- Bot bubble: light primary-color tint
- User bubble: light neutral gray

### Shapes

Use rounded corners throughout the interface, including:

- Toggle button
- Chat window
- Header
- Message bubbles
- Input field
- Send button
- Quick reply buttons, if added later

### Shadows

Use soft shadows to establish depth while avoiding heavy borders or harsh contrast.

## Interactions

### Open and Close

- Toggle button opens and closes the chat window
- Chat window fades in and slides upward when opened
- Closing the window reverses the animation where supported
- The close control should be keyboard accessible

### Bot Replies

- Bot replies should appear after a short delay to feel natural
- A `typing...` indicator may appear during the delay
- The interface should remain responsive while a reply is pending

### Hover and Focus

- Toggle and send buttons slightly enlarge or brighten on hover
- Interactive controls must have visible keyboard focus states
- Buttons should provide accessible labels when using icons without text

## Positioning

- Use `position: fixed`
- Align the widget to the right side of the viewport
- Keep a small, consistent gap from the right and bottom edges
- Place the chat window and toggle above the existing WhatsApp button
- Ensure the widget does not cover important navigation or content
- Use an appropriate stacking order so it remains visible above page content

## Responsiveness

### Desktop

- Use a compact medium-width chat window
- Maintain comfortable message spacing and readable text
- Keep the window aligned with the floating toggle button

### Mobile

- Make the chat window wider while preserving side margins
- Keep the input and send controls easy to use with a thumb
- Prevent the chat window from exceeding the viewport height
- Allow the messages area to scroll independently
- Avoid covering the full page unless required by the viewport size

## Accessibility

- Use semantic buttons for toggle, close, and send controls
- Provide accessible labels for icon-only buttons
- Support keyboard navigation and `Escape` to close the window
- Maintain sufficient color contrast
- Respect `prefers-reduced-motion` by reducing or disabling animations
- Announce new bot messages where appropriate with an accessible live region

## Future Enhancements

- Quick reply buttons
- Emoji support
- Typing animation
- Conversation history
- Persistent chat state
- Integration with a real chatbot or support API
- Unread message indicator

## Success Criteria

The chatbot UI should:

- Look modern, rounded, and trustworthy
- Feel responsive and immediate
- Fit naturally into the WordPress website
- Remain positioned cleanly above the WhatsApp button
- Work well on desktop and mobile
- Encourage visitors to start a conversation without needing instructions
