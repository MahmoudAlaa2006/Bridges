@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.candidate_sidebar')
@endsection
@section('title', 'Technical Assessment — CareerPortal')
@section('header-title', 'Technical Assessment')

@section('header-actions-prefix')
@endsection

@section('content')

    <!-- Sticky exam header -->
    <div class="exam-sticky">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <p style="font-size:12px;color:var(--muted-fg);margin:0">Senior Frontend Developer</p>
          <p style="font-size:14px;font-weight:600;margin:0">6 questions &nbsp;·&nbsp; Answer all to maximize your score</p>
        </div>
        <div class="d-flex align-items-center gap-4">
          <!-- Static timer display — in a real app this would count down -->
          <div class="text-center">
            <div class="exam-timer">45:00</div>
            <p class="text-muted-cp" style="font-size:11px;margin:0">Time Remaining</p>
          </div>
          <button onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Submit Exam
          </button>
        </div>
      </div>
    </div>

    <!-- All questions in one scrollable page -->
    <div class="d-flex flex-column gap-4">

      <!-- ====================================================
           SECTION: MULTIPLE CHOICE (Questions 1–3)
           ==================================================== -->
      <div>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="cp-badge badge-yellow">Multiple Choice</span>
          <span class="text-muted-cp" style="font-size:13px">3 questions · 20 pts each · 60 pts total</span>
        </div>
        <div class="d-flex flex-column gap-3">

          <!-- Q1 -->
          <div class="q-block" id="qblock-1">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-1">1</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">What is a closure in JavaScript?</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Multiple Choice &nbsp;·&nbsp; 20 points</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-2" data-question="1">
              <button class="exam-option" onclick="selectOption(1, 0)">
                <input type="radio" name="q1"> A function that is immediately invoked after it is defined (IIFE)
              </button>
              <button class="exam-option" onclick="selectOption(1, 1)">
                <input type="radio" name="q1"> A function that retains access to its outer scope even after the outer function has returned
              </button>
              <button class="exam-option" onclick="selectOption(1, 2)">
                <input type="radio" name="q1"> A way to prevent variables from being declared in the global scope
              </button>
              <button class="exam-option" onclick="selectOption(1, 3)">
                <input type="radio" name="q1"> A design pattern for managing asynchronous operations
              </button>
            </div>
          </div>

          <!-- Q2 -->
          <div class="q-block" id="qblock-2">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-2">2</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">Which React hook is used to perform side effects in a functional component?</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Multiple Choice &nbsp;·&nbsp; 20 points</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-2" data-question="2">
              <button class="exam-option" onclick="selectOption(2, 0)">
                <input type="radio" name="q2"> useState
              </button>
              <button class="exam-option" onclick="selectOption(2, 1)">
                <input type="radio" name="q2"> useRef
              </button>
              <button class="exam-option" onclick="selectOption(2, 2)">
                <input type="radio" name="q2"> useEffect
              </button>
              <button class="exam-option" onclick="selectOption(2, 3)">
                <input type="radio" name="q2"> useCallback
              </button>
            </div>
          </div>

          <!-- Q3 -->
          <div class="q-block" id="qblock-3">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-3">3</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">What is the primary purpose of <code style="background:var(--secondary);padding:1px 6px;border-radius:4px;font-size:13px">useMemo</code> in React?</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Multiple Choice &nbsp;·&nbsp; 20 points</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-2" data-question="3">
              <button class="exam-option" onclick="selectOption(3, 0)">
                <input type="radio" name="q3"> To memoize a callback function so it is not re-created on every render
              </button>
              <button class="exam-option" onclick="selectOption(3, 1)">
                <input type="radio" name="q3"> To cache an expensive computed value and recompute it only when dependencies change
              </button>
              <button class="exam-option" onclick="selectOption(3, 2)">
                <input type="radio" name="q3"> To store a mutable value that does not trigger a re-render when updated
              </button>
              <button class="exam-option" onclick="selectOption(3, 3)">
                <input type="radio" name="q3"> To manage global state across components without prop drilling
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- ====================================================
           SECTION: WRITTEN (Questions 4–5)
           ==================================================== -->
      <div>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="cp-badge badge-purple">Written</span>
          <span class="text-muted-cp" style="font-size:13px">2 questions · 15 pts each · 30 pts total</span>
        </div>
        <div class="d-flex flex-column gap-3">

          <!-- Q4 -->
          <div class="q-block" id="qblock-4">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-4">4</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">Explain the difference between synchronous and asynchronous programming in JavaScript. Give a real-world example of each.</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Written Response &nbsp;·&nbsp; 15 points &nbsp;·&nbsp; Minimum 50 characters</p>
              </div>
            </div>
            <textarea class="cp-input" placeholder="Write your answer here…" rows="5" style="min-height:120px"></textarea>
            <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">Clear, well-structured answers are preferred. No word limit.</p>
          </div>

          <!-- Q5 -->
          <div class="q-block" id="qblock-5">
            <div class="d-flex align-items-start gap-3 mb-3">
              <span class="q-num" id="qnum-5">5</span>
              <div>
                <p style="font-size:14px;font-weight:600;margin:0 0 2px">Describe your experience with React state management. Which approach do you prefer (Context API, Redux, Zustand, etc.) and why?</p>
                <p class="text-muted-cp" style="font-size:12px;margin:0">Written Response &nbsp;·&nbsp; 15 points</p>
              </div>
            </div>
            <textarea class="cp-input" placeholder="Write your answer here…" rows="5" style="min-height:120px"></textarea>
          </div>

        </div>
      </div>

      <!-- ====================================================
           SECTION: CODING (Question 6)
           ==================================================== -->
      <div>
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="cp-badge badge-blue">Coding</span>
          <span class="text-muted-cp" style="font-size:13px">1 question · 10 pts</span>
        </div>

        <!-- Q6 -->
        <div class="q-block" id="qblock-6">
          <div class="d-flex align-items-start gap-3 mb-3">
            <span class="q-num" id="qnum-6">6</span>
            <div>
              <p style="font-size:14px;font-weight:600;margin:0 0 2px">Write a JavaScript function that takes an array of numbers and returns the sum of all even numbers in the array.</p>
              <p class="text-muted-cp" style="font-size:12px;margin:0">Coding &nbsp;·&nbsp; 10 points</p>
            </div>
          </div>

          <!-- Example input/output -->
          <div class="p-3 rounded-3 mb-3" style="background:var(--secondary);border:1px solid var(--border)">
            <p style="font-size:12px;font-weight:600;color:var(--muted-fg);margin:0 0 6px">Example</p>
            <code style="font-size:12px;color:#a5f3fc">sumEvenNumbers([1, 2, 3, 4, 5, 6])</code>
            <span style="font-size:12px;color:var(--muted-fg)"> → </span>
            <code style="font-size:12px;color:#86efac">12</code>
            <br>
            <code style="font-size:12px;color:#a5f3fc">sumEvenNumbers([1, 3, 5])</code>
            <span style="font-size:12px;color:var(--muted-fg)"> → </span>
            <code style="font-size:12px;color:#86efac">0</code>
          </div>

          <textarea class="code-input" placeholder="// Write your solution here&#10;function sumEvenNumbers(numbers) {&#10;  // your code&#10;}"></textarea>
          <p class="text-muted-cp mt-1 mb-0" style="font-size:11px">You may use any valid JavaScript syntax (ES5, ES6+).</p>
        </div>
      </div>

      <!-- Submit button at bottom of page -->
      <div class="d-flex justify-content-end gap-3 pb-4">
        <!-- <a href="exam.html" class="btn-cp btn-outline-cp">Save &amp; Exit</a> -->
        <button onclick="confirmSubmit()" class="btn-cp btn-primary-cp">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          Submit Exam
        </button>
      </div>

@endsection

@push('scripts')
<script src="{{ asset('js/exam-active.js') }}"></script>
@endpush

