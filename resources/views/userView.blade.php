<div>
        <label for="w3review">Enter Text:</label>
        <br/>  
        <textarea onChange="" id="description" name="description" rows="10" cols="70"></textarea> 
        {{-- <div id="countText">Total words: 0</div> --}}
        <button id="count_btn" onclick="count()" type="submit">count word:</button>
 </div>
 <script>
    let largest = (word)=>{
        let splitArr = word.split(" ");
        let largestWord = splitArr[0];
        for (let i = 1; i < splitArr.length; i++) {
            if (largestWord.length < splitArr[i].length) {
                largestWord = splitArr[i];
            }
        }
        return largestWord;
    }
    
    console.log(largest('PHP Laravel Ruby',''));
    
 </script>